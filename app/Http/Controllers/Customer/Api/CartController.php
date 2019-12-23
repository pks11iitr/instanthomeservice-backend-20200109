<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;

class CartController extends Controller
{

      public function store(Request $request){

          $user=  auth()->user();
          //var_dump($user->toArray());

          $request->validate([
  				'quantity'=>'required|integer|min:0',
                'product_id'=>'required|integer|min:1',
                'size'=>'required|integer|min:0',
                //'price'=>'required|integer|min:1'
  				]);
          $size=Size::findOrFail($request->size);
          $cart = Cart::where('product_id',$request->product_id)->where('userid', $user->id)->first();
            //die;
          if(!$cart){
              if($request->quantity>0){
                Cart::create([
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'userid'=>$user->id,
                    'size_id'=>$request->size,
                ]);
              }

          }else{
            if($request->quantity>0){
              $cart->quantity=$request->quantity;
              $cart->size_id=$request->size;
              $cart->save();
            }else{

              $cart->delete();
            }
          }

          return [
            'message'=>'success'
          ];

      }

      public function getCartDetails(Request $request){
          $user=  auth()->user();
          return $user->cart;

      }
}
