<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Coupon;
use App\Models\OrderStatus;
use App\Models\Review;
use App\Models\Size;
use App\Models\TimeSlot;
use App\Models\Wallet;
use App\Services\Payment\RazorPayService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Order_items;
use PDF;

class OrderController extends Controller
{
    public function __construct(RazorPayService $pay)
    {
        $this->pay=$pay;
    }

    public function make(Request $request){
        $user=auth()->user();
        $cart=$user->cart()->with(['product'])->get();
        $total=0;
        if(count($cart)){

            //delete all incomplete order
            Orders::where('user_id', $user->id)->where('isbookingcomplete', false)->delete();

            $order=Orders::create(['user_id'=>$user->id, 'order_id'=>date('YmdHis')]);
            $order=$order->refresh();
            OrderStatus::create(['order_id'=>$order->id, 'status'=>$order->status]);
              foreach($cart as $c){
                //echo $c->product_id;

                    Order_items::create([
                                        'order_id'=>$order->id,
                                        'quantity'=>$c->quantity,
                                        'price'=>$c->product->price,
                                        'product_id'=>$c->product_id,
                                      ]);
                    $total=$total+$c->quantity*$c->product->price;
              }
              $order->total_paid=$total;
              if($order->save()){
                return [
                  'message'=>'success',
                  'orderid'=>$order->id
                ];
              }
        }else{
          return [
            'message'=>'cart is empty',
            'orderid'=>''
          ];
        }
    }

    public function makeQuery(Request $request, $id){
            $user=auth()->user();
            $product=Products::active()->find($id);
            if($product) {
                if($product->flow==2){
                    Orders::where('user_id', $user->id)->where('isbookingcomplete', false)->delete();
                    $order=Orders::create(['user_id'=>$user->id, 'isbookingcomplete'=>true, 'order_id'=>date('YmdHis')]);
                    Cart::remove($user,null);
                    $order=$order->refresh();
                    OrderStatus::create(['order_id'=>$order->id, 'status'=>$order->status]);
                    Order_items::create([
                        'order_id'=>$order->id,
                        'quantity'=>1,
                        'price'=>null,
                        'product_id'=>$id,
                    ]);
                    return [
                        'status'=>'success',
                        'orderid'=>$order->id,
                        'message'=>'Thank you, your request has been submitted. Our executive will call you regarding prices of the products'
                    ];
                }else{
                    return [
                        'status'=>'failed',
                        'orderid'=>'',
                        'message'=>'This action is not valid'
                    ];
                }
            }else{
                return [
                    'status'=>'failed',
                    'orderid'=>'',
                    'message'=>'This action is not valid'
                ];
            }
    }

    public function makeRentQuery(Request $request){
        $request->validate([
            'product_id'=>'required|array',
            'product_id.*'=>'required|integer',
            'quantity'=>'required|array',
            'quantity.*'=>'required|integer',
            'address'=>'required|string|max:300',
            'name'=>'required|string|max:100',
            'auto_address'=>'required|string|max:300',
            'lat'=>'required|numeric',
            'lang'=>'required|numeric',
        ]);

        $user=auth()->user();

        $products=[];
        $i=0;
        foreach($request->product_id as $pid)
        {
            $products[$pid]=$request->quantity[$i];
            $i++;
        }

        Orders::where('user_id', $user->id)->where('isbookingcomplete', false)->delete();

        $order=Orders::create(['user_id'=>$user->id,
            'isbookingcomplete'=>true,
            'address'=>$request->address,
            'auto_address'=>$request->auto_address,
            'name'=>$request->name,
            'lat'=>$request->lat,
            'lang'=>$request->lang,
            'order_id'=>date('YmdHis')]);
        $order=$order->refresh();
        OrderStatus::create(['order_id'=>$order->id, 'status'=>$order->status]);
        foreach($products as $product=>$quantity){

            Order_items::create([
                'order_id'=>$order->id,
                'quantity'=>$quantity,
                'price'=>null,
                'product_id'=>$product,
            ]);
        }
        Cart::remove($user,null);
        return [
            'status'=>'success',
            'orderid'=>$order->id,
            'message'=>'Thank you, your request has been submitted. Thanks our executive will call you regarding prices of the products'
        ];
    }


    public function history(Request $request){
          $user=auth()->user();
          $orders=Orders::with(['details'])->where('user_id', $user->id)->orderBy('updated_at', 'desc')->where('isbookingcomplete',true)->get();

          $orderarray=[];
          foreach($orders as $o){
              $items=$o->details()->select('quantity')->get();
              $items=$items->map(function($value, $key){
                  return $value['quantity'];
              });
              $items=array_sum($items->toArray());
              $orderarray[]=['id'=>$o->id, 'order_id'=>$o->order_id, 'date'=>date('D,d M H:i  A', strtotime($o->created_at)), 'items'=>count($o->details).' Services/ '.$items.' Items'];
          }
          return $orderarray;
    }

    public function details(Request $request, $id){
        $user=auth()->user();
        $order=Orders::with(['details.product','reviews'])->where('user_id', $user->id)->findOrFail($id);
        $orderdata=[];
        $orderdata['total']=$order->total_paid;
        $orderdata['taxes']=0;
        $orderdata['name']=$order->name??'Not available';
        $orderdata['address']=$order->address??'Not Available';
        $orderdata['order_id']=$order->order_id;
        $orderdata['status']=$order->status;
        $orderdata['lat']=$order->lat;
        $orderdata['lang']=$order->lang;
        $orderdata['price_after_inspection']=$order->total_after_inspection+$order->instant_discount;
        $orderdata['coupon']=$order->coupon;
        $orderdata['discount']=$order->instant_discount;
        $orderdata['reviews']=$order->reviews;
        $orderdata['id']=$order->id;
        $orderdata['invoice_url']=route('download.invoice', ['id'=>$order->order_id]);
        if(isset($order->booking_date))
            $orderdata['time']=date('D, d M', strtotime($order->booking_date)).(isset($order->time->name)?'('.$order->time->name.')':'');
        else
            $orderdata['time']='NA';
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


    public function getTimeSlots(Request $request){
        $timeslots=TimeSlot::active()->get();
        $date=date('Y-m-d');
        $dates=[];
        for($i=0;$i<7;$i++){
            $dates[]=['date'=>date('Y-m-d', strtotime("+$i days")), 'display'=>date('D,d M', strtotime("+$i days"))];
        }

        return compact('timeslots', 'dates');
    }

    public function setAddress(Request $request, $id){
        $request->validate([
            'address'=>'required|string|max:300',
            'name'=>'required|string|max:100',
            'auto_address'=>'required|string|max:300',
            'lat'=>'required|numeric',
            'lang'=>'required|numeric',
        ]);

        $order=Orders::where('user_id', auth()->guard('api')->user()->id)->where('isbookingcomplete', false)->findOrFail($id);
        if($order->update($request->only('address', 'auto_address', 'lat', 'lang', 'name'))){
            return [
                'status'=>'success'
            ];
        }
        return [
            'status'=>'failed',
            'message'=>'Address update failed'
        ];
    }

    public function setTime(Request $request, $id){
        $request->validate([
            'booking_date'=>'required|date_format:Y-m-d',
            'booking_time'=>'required|integer|min:1|max:12'
        ]);
        $user=auth()->user();
        $order=Orders::where('user_id', $user->id)->where('isbookingcomplete', false)->findOrFail($id);
        if($order->update(array_merge($request->only('booking_date', 'booking_time'), [ 'isbookingcomplete'=>true]))){
            //clear cart
            Cart::remove($user);
            return [
                'status'=>'success'
            ];
        }
        return [
            'status'=>'failed',
            'message'=>'Booking time update failed'
        ];
    }

    public function review(Request $request, $id){
        $request->validate([
            'rating'=>'required|integer|in:1,2,3,4,5',
            'review'=>'string'
        ]);
        $user=auth()->guard('api')->user();
        if($user){
            $order=Orders::with('details')->where('user_id', $user->id)->where('status', 'paid')->findOrFail($id);

            $root=$category=$order->details[0]->product->category;
            while($root->rootcategory!=null)
                $root=$root->rootcategory;

            $review=new Review(['ratings'=>$request->rating, 'review'=>$request->review,'user_id'=>$user->id, 'category_id'=>$root->id]);
            $order->reviews()->save($review);
            return [
                'status'=>'success',
                'message'=>'Review has been submitted'
            ];
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];

    }

    public function paynow(Request $request, $id){
        $user=auth()->user();
        if($user){
            $order=Orders::where('status', 'completed')->findOrFail($id);
            if(!$order->applyCoupon($request->coupon)){
                return [
                    'status'=>'failed',
                    'message'=>'Coupon is not valid'
                ];
            }
            if($request->usewallet==1){
                $balance=Wallet::balance($user->id);
                if($balance>=$order->total_after_inspection){

                    $vendor=$order->vendors()->where('vendor_orders.status', 'completed')->firstOrFail();
                    $vendor->pivot->status='paid';
                    $vendor->pivot->save();
                    $order->status='paid';
                    OrderStatus::create(['order_id'=>$order->id, 'status'=>$order->status]);
                    $order->using_wallet=true;
                    $order->from_wallet=$order->total_after_inspection;
                    $order->save();

                    Wallet::updatewallet($user->id, 'Paid for Booking ID:'.$order->order_id, 'Debit', $order->total_after_inspection);

                   return response()->json([
                        'status'=>'success',
                        'paymentdone'=>'yes',
                        'message'=>'Your booking payment has been successfull'
                    ]);
                }else{
                    $order->using_wallet=true;
                    $order->from_wallet=$balance;
                    $order->save();

                    $final_cost=($order->total_after_inspection-$balance)*100;

                    $response=$this->pay->generateorderid([
                        "amount"=>$final_cost,
                        "currency"=>"INR",
                        "receipt"=>$order->id.'',
                    ]);
                }
            }else{
                $order->using_wallet=false;
                $order->from_wallet=0;
                $order->save();
                $final_cost=$order->total_after_inspection*100;

                $response=$this->pay->generateorderid([
                    "amount"=>$final_cost,
                    "currency"=>"INR",
                    "receipt"=>$order->order_id.'',
                ]);
            }

            $responsearr=json_decode($response);
            if(isset($responsearr->id)){
                $order->razor_order_id=$responsearr->id;
                $order->order_id_response=$response;
                //$order->using_wallet=($request->usewallet==1)?true:false;
                $order->save();
                return response()->json([
                    'status'=>'success',
                    'message'=>'success',
                    'paymentdone'=>'no',
                    'data'=>[
                        'id'=>$order->id,
                        'orderid'=> $order->razor_order_id,
                        'total'=>$final_cost
                    ]
                ], 200);
            }else{
                return response()->json([
                    'status'=>'failed',
                    'message'=>'Payment cannot be initiated',
                    'data'=>[
                    ],
                ], 200);
            }
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];

    }

    public function verifyPayment(Request $request){
        $user=auth()->user();
        if($user){
            $order=Orders::where('razor_order_id', $request->razorpay_order_id)->firstOrFail();
            $paymentresult=$this->pay->verifypayment($request->all());
            if($paymentresult){
                $order->payment_id=$request->razorpay_payment_id;
                $order->payment_id_response=$request->razorpay_signature;
                $order->status='paid';

                OrderStatus::create(['order_id'=>$order->id, 'status'=>$order->status]);

                if($order->using_wallet==1){
                    $balance=Wallet::balance($order->user_id);
                    if($balance>=$order->from_wallet){
                        Wallet::updatewallet($order->user_id, 'Paid for Booking ID:'.$order->order_id, 'Debit', $order->from_wallet);
                    }else{
                        return response()->json([
                            'status'=>'failed',
                            'message'=>'Payment is not successfull',
                            'errors'=>[

                            ],
                        ], 200);
                    }

                }

                $order->save();
                $order->vendors()->where('vendor_orders.status', '=', 'completed')->update(['vendor_orders.status'=>'paid']);
                return response()->json([
                    'status'=>'success',
                    'message'=>'Payment is successfull',
                    'errors'=>[

                    ],
                ], 200);
            }else{
                return response()->json([
                    'status'=>'failed',
                    'message'=>'Payment is not successfull',
                    'errors'=>[

                    ],
                ], 200);
            }
        }

        return [
            'status'=>'failed',
            'message'=>'logout'
        ];

    }

    public function checkCoupon(Request $request){
        $request->validate([
            'coupon'=>'required',
            'id'=>'required|integer'
        ]);

        $order=Orders::findOrFail($request->id);

        $coupon=Coupon::where('code', $request->coupon)->first();
        if(!($coupon && $coupon->isValid())){
            return [
                'status'=>'failed',
                'message'=>'Coupon is not valid',
                'amount'=>0
            ];
        }
        $discount=$coupon->calculateDiscount($order->total_after_inspection);
        return [
            'status'=>'success',
            'message'=>'Coupon applied successfully.',
            'amount'=>$discount
        ];
    }


    public function invoice(Request $request, $refid){
        $order=Orders::with(['details.product','reviews'])->where('order_id', $refid)->firstOrFail();

        $pdf = PDF::loadView('invoice', compact('order'));
        return $pdf->download('invoice.pdf');

    }
}
