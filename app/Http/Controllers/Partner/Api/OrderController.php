<?php

namespace App\Http\Controllers\Partner\Api;

use App\Models\Orders;
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
                    $vendor->where('vendor_id', $user->id)->whereIn('vendor_orders.status', ['new', 'accepted']);
            })
            ->select('id', 'order_id', 'lat', 'lang', 'booking_time','booking_date', DB::raw("$haversine as distance"))
        ->get();
        $ordersarr=[];
        foreach($orders as $o){
            $o->time1=date('D, d M', strtotime($o->booking_date)).' '.$o->time->name;
            unset($o->time);
            $o->time=$o->time1;
            unset($o->time1);
            $ordersarr[]=$o;
        }
        return $ordersarr;
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

        $order=Orders::with(['details.product'])->whereHas('vendors', function($vendor) use($user){
            $vendor->where('vendor_id', $user->id);
        })->findOrFail($id);

        $orderdata=[];
        $orderdata['total']=$order->total_paid;
        $orderdata['taxes']=0;
        $orderdata['name']=$order->name;
        $orderdata['address']=$order->address;
        $orderdata['lat']=$order->lat;
        $orderdata['lang']=$order->lang;
        $orderdata['price_after_inspection']=$order->total_after_inspection;
        $orderdata['time']=date('D, d M').'('.$order->time->name.')';
        //$orderdata['date']=$order->updated_at;
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
            $order=Orders::whereHas('vendors',function($vendor) use ($user){
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
                $order->update(['total_after_inspection'=>$request->estimate]);

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

}
