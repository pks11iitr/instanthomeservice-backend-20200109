<?php

namespace App\Http\Controllers\Partner\Api;

use App\Models\Orders;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index(Request $request){
        $user=auth()->user();
        switch($request->type){
            case 'past':return $this->pastOrders($request, $user);
            default:return $this->openOrders($request, $user);
        }

    }


    public function openOrders(Request $request, $user){
        $lat=$request->lat;
        $lang=$request->lang;
        $haversine = "(6371 * acos(cos(radians($lat))
                     * cos(radians(orders.lat))
                     * cos(radians(orders.lang)
                     - radians($lang))
                     + sin(radians($lat))
                     * sin(radians(orders.lat))))";
        $orders=Orders::with('time')
            ->whereHas('vendors', function($vendor) use($user){
                    $vendor->where('vendor_id', $user->id)->whereIn('vendor_orders.status', ['new', 'accepted','completed', 'paid']);
            })
            ->select('id', 'order_id', 'lat', 'lang', 'booking_time','booking_date', DB::raw("$haversine as distance"))->orderBy('id','desc')
        ->get();
        $ordersarr=[];
        foreach($orders as $o){
            if(empty($o->lat) || empty($o->lang))
                $o->distance='Not Available';
            if(!empty($o->booking_date) && !empty($o->booking_time)){
                $o->time1=date('D, d M', strtotime($o->booking_date)).' '.($o->time->name??'');
                unset($o->time);
                $o->time=$o->time1;
                unset($o->time1);
                $ordersarr[]=$o;
            }else{
                $o->time1='Not Available';
                unset($o->time);
                $o->time=$o->time1;
                unset($o->time1);
                $ordersarr[]=$o;
            }

        }

        $balance=Wallet::balance($user->id);
        if($balance<config('config.vendorfee')){
            $balance='Please recharge your wallet to accept orders.';
        }else{
            $balance='';
        }
        if(!$user->agreement_signed)
            $agreement='Please sign agreement to start working. Go to profile settings';
        else
            $agreement='';

        return compact('orders','agreement', 'balance');
    }

    public function pastOrders(Request $request, $user){
        $orders=Orders::with(['vendors'=>function($vendor){
            $vendor->select('vendor_orders.status');
        }])->whereHas('vendors',function($vendor) use($user){
            $vendor->where('vendor_id', $user->id)->whereNotIn('vendor_orders.status', ['new', 'accepted']);
        })->select('id', 'order_id', 'booking_time','booking_date')->get();
        $ordersarr=[];
        foreach($orders as $o){
            $o->time1=date('D, d M', strtotime($o->booking_date)).' '.$o->time->name;
            unset($o->time);
            $o->time=$o->time1;
            unset($o->time1);
            $ordersarr[]=$o;
        }
        return $orders;

    }

    public function details(Request $request, $id){
        $user=auth()->user();

        $order=Orders::with(['details.product', 'vendors'=>function($vendors)use($user){
            $vendors->where('vendor_id', $user->id);
        }])->whereHas('vendors', function($vendor) use($user){
            $vendor->where('vendor_id', $user->id);
        })->findOrFail($id);

        $orderdata=[];
        $orderdata['total']=$order->total_paid;
        $orderdata['taxes']=0;
        $orderdata['order_id']=$order->order_id;
        $orderdata['name']=$order->name;
        $orderdata['address']=$order->address;
        $orderdata['lat']=$order->lat;
        $orderdata['lang']=$order->lang;
        $orderdata['price_after_inspection']=$order->total_after_inspection;
        if(isset($order->booking_date))
            $orderdata['time']=date('D, d M', strtotime($order->booking_date)).(isset($order->time->name))?'('.$order->time->name.')':'';
        else
            $orderdata['time']='NA';
        //$orderdata['date']=$order->updated_at;
        $orderdata['orderstatus']=$order->status;
        $orderdata['vendorrstatus']=$order->vendors[0]->pivot->status??'';
        $orderdata['items']=[];
        foreach($order->details as $d){
            $orderdata['items'][]=[
                'name'=>$d->product->category->title.'('.$d->product->name.')',
                'unitprice'=>$d->product->price,
                'quantity'=>$d->quantity,
                'total'=>$d->product->price*$d->quantity,
                'image'=>$d->product->image
            ];
        }

        if($orderdata['orderstatus']=='new' && $orderdata['vendorrstatus']=='rejected'){
            $orderdata['status']='Rejected';
            $orderdata['name']='';
            $orderdata['address']='';
            $orderdata['lat']='';
            $orderdata['lang']='';
            $orderdata['price_after_inspection']='';
            $orderdata['time']='';
        }elseif($orderdata['orderstatus']=='assigned' && $orderdata['vendorrstatus']=='new'){
            $orderdata['status']='new'; //show accept/reject button
            $orderdata['name']='';
            $orderdata['address']='';
            $orderdata['lat']='';
            $orderdata['lang']='';
            $orderdata['price_after_inspection']='';
            $orderdata['time']='';
        }elseif($orderdata['orderstatus']=='accepted' && $orderdata['vendorrstatus']=='accepted'){
            $orderdata['status']='accepted';//show process button
        }elseif($orderdata['orderstatus']=='processing' && $orderdata['vendorrstatus']=='accepted'){
            $orderdata['status']='processing';//show complete button
        }elseif($orderdata['orderstatus']=='new' && $orderdata['vendorrstatus']=='expired'){
            $orderdata['status']='Expired';
            $orderdata['name']='';
            $orderdata['address']='';
            $orderdata['lat']='';
            $orderdata['lang']='';
            $orderdata['price_after_inspection']='';
            $orderdata['time']='';
        }elseif($orderdata['orderstatus']=='completed' && $orderdata['vendorrstatus']=='completed'){
            $orderdata['status']='Waiting For Payment';
        }elseif($orderdata['orderstatus']=='paid' && $orderdata['vendorrstatus']=='completed'){
            $orderdata['status']='Payment Completed';
        }else{
            $orderdata['status']='';
            $orderdata['name']='';
            $orderdata['address']='';
            $orderdata['lat']='';
            $orderdata['lang']='';
            $orderdata['price_after_inspection']='';
            $orderdata['time']='';
        }

        return $orderdata;
    }

    public function completeService(Request $request, $id){
        $request->validate([
            'preimage'=>'required|array',
            'preimage.*'=>'image',
            'postimage'=>'required|array',
            'postimage.*'=>'image',
            'billimage'=>'required|image',
            'estimate'=>'required|integer'

        ]);

        $user=auth()->user();
        if($user){
            $order=Orders::whereIn('orders.status', ['processing', 'completed'])->whereHas('vendors',function($vendor) use ($user){
                $vendor->whereIn('vendor_orders.status', ['accepted','completed'])->where('vendor_id', $user->id);
        })->findOrFail($id);
            if($order){
                foreach($request->preimage as $image){
                    $order->saveDocument($image, 'preimage');
                }
                foreach($request->postimage as $image){
                    $order->saveDocument($image, 'postimage');
                }
                $order->saveDocument($image, 'billimage');
                //var_dump($request->estimate);die;
                $order->update(['total_after_inspection'=>$request->estimate, 'status'=>'completed']);

                $vendor=$order->vendors()->where('vendor_id', $user->id)->firstOrFail();
                $vendor->pivot->status='completed';
                $vendor->pivot->save();



                return [
                    'status'=>'status',
                    'message'=>'Order has been updated'
                ];
            }
            return [
                'status'=>'failed',
                'message'=>'No such order'
            ];
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];

    }

    public function acceptOrder(Request $request, $id){
        $user=auth()->user();
        if($user){
            $order=Orders::whereHas('vendors', function($vendors) use ($user){
                $vendors->where('vendor_orders.status', 'new')->where('vendor_id', $user->id);
            })->where('orders.status', 'assigned')->findOrFail($id);
            if($order){
                $ballance=Wallet::balance($user->id);
                if(!$user->agreement_signed)
                    return [
                        'status'=>'failed',
                        'message'=>'Please sign agreement with us. Go to profile settings.'
                    ];

                if($ballance>=config('config.vendorfee')){
                    //update status i.e. update pivot
                    $vendor=$order->vendors()->where('vendor_id', $user->id)->firstOrFail();
                    $vendor->pivot->status='accepted';
                    $vendor->pivot->save();

                    //change order status
                    $order->status='accepted';
                    $order->save();

                    //update wallet history
                    Wallet::updatewallet($user->id, 'Service fee deducted for Booking ID: '.$order->refid, 'Debit', config('config.vendorfee'),$orderid=$order->id);


                    return [
                        'status'=>'success',
                        'message'=>'Booking has been accepted'
                    ];
                }else{
                    return [
                        'status'=>'failed',
                        'message'=>'Booking cannot be accepted. Please recharge your wallet'
                    ];
                }
            }
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];
    }

    public function rejectOrder(Request $request, $id){
        $user=auth()->user();
        if($user){
            $order=Orders::whereHas('vendors', function($vendors) use ($user){
                $vendors->where('vendor_orders.status', 'new')->where('vendor_id', $user->id);
            })->where('orders.status', 'assigned')->findOrFail($id);
            if($order){
                // reject booking i.e. update pivot
                $vendor=$order->vendors()->where('vendor_id', $user->id)->firstOrFail();
                $vendor->pivot->status='rejected';
                $vendor->pivot->save();

                //change order status to new
                $order->status='new';
                $order->save();

                return [
                        'status'=>'success',
                        'message'=>'You have rejected this booking'
                    ];
            }
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];
    }

    public function startProcessing(Request $request, $id){
        $user=auth()->user();
        if($user){
            $order=Orders::whereHas('vendors', function($vendors) use ($user){
                $vendors->where('vendor_orders.status', 'accepted')->where('vendor_id', $user->id);
            })->where('orders.status', 'accepted')->findOrFail($id);
            if($order){

                //change order status to processing
                $order->status='processing';
                $order->save();

                return [
                    'status'=>'success',
                    'message'=>'You have started working on it.'
                ];
            }
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];
    }


    public function markAsPaid(Request $request, $id){
        $user=auth()->user();
        if($user){
            $order=Orders::whereHas('vendors', function($vendors) use ($user){
                $vendors->where('vendor_orders.status', 'completed')->where('vendor_id', $user->id);
            })->where('orders.status', 'completed')->findOrFail($id);
            if($order){

                //change order status to processing
                $order->status='paid';
                $order->payment_mode='code';
                $order->save();

                return [
                    'status'=>'success',
                    'message'=>'Payment has been marked as COD.'
                ];
            }
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];
    }

}
