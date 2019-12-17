<?php

namespace App\Http\Controllers\Customer\Api;

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
        $cart=Cart::where('userid', $user->id)->get();
        $order=Orders::create(['user_id'=>$user->id]);
        $total=0;
        if(count($cart)){

          foreach($cart as $c){
            //echo $c->product_id;

            Order_items::create(['order_id'=>$order->id,
                                'quantity'=>$c->quantity,
                                'price'=>$c->product->price,
                                'product_id'=>$c->product_id
                              ]);
                  $total=$total+$c->quantity*$c->product->price;
          }
          //die;
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

    public function history(Request $request){
          $user=auth()->user();
          $orders=Orders::where('user_id', $user->id)->get();
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
}
