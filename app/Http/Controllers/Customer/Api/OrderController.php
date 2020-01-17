<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Size;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Order_items;
class OrderController extends Controller
{
    public function make(Request $request){
        $user=auth()->user();
        $cart=$user->cart()->with(['product'])->get();
        $total=0;
        if(count($cart)){

            //delete all incomplete order
            Orders::where('user_id', $user->id)->where('isbookingcomplete', false)->delete();

            $order=Orders::create(['user_id'=>$user->id]);
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
                    $order=Orders::create(['user_id'=>$user->id, 'isbookingcomplete'=>true]);
                    Order_items::create([
                        'order_id'=>$order->id,
                        'quantity'=>1,
                        'price'=>null,
                        'product_id'=>$id,
                    ]);
                    return [
                        'status'=>'success',
                        'orderid'=>$order->id,
                        'message'=>'Your request has been submitted. Our team will contact you shortly'
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


    public function history(Request $request){
          $user=auth()->user();
          $orders=Orders::with(['details.product', 'details.sizeprice'])->where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
          return $orders;
    }

    public function details(Request $request, $id){
        $order=Orders::with(['details.product'])->findOrFail($id);

        $orderdata=[];
        $orderdata['total']=$order->total_paid;
        $orderdata['taxes']=0;
        $orderdata['date']=$order->updated_at;
        $orderdata['items']=[];
        foreach($order->details as $d){
          $orderdata['items'][]=[
            'name'=>$d->product->name,
            'unitprice'=>$d->product->price,
            'quantity'=>$d->quantity,
            'total'=>$d->product->price*$d->quantity
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
        $user=auth()->guard('api')->user();
        $order=Orders::where('user_id', $user->id)->where('isbookingcomplete', false)->findOrFail($id);
        if($order->update(array_merge($request->only('booking_date', 'booking_time'), [ 'isbookingcomplete'=>true]))){
            //clear cart
            $user->cart()->delete();
            return [
                'status'=>'success'
            ];
        }
        return [
            'status'=>'failed',
            'message'=>'Booking time update failed'
        ];
    }
}
