<?php

namespace App\Http\Controllers\Customer\Api;

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
          'product_id'=>'required|integer|min:1'
  				]);

          $cart = Cart::where('product_id',$request->product_id)->first();
            //die;
          if(!$cart){
              if($request->quantity>0){
                Cart::create([
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'userid'=>$user->id
                ]);
              }

          }else{
            if($request->quantity>0){
              $cart->quantity=$request->quantity;
              $cart->save();
            }else{

              $cart->delete();
            }
          }

          return [
            'message'=>'success'
          ];

      }


        public function update(Request $request,$id){
          $request->validate([
          'quantity'=>'required'
          ]);

            $cart = Cart::findOrFail($id);

                 if($cart->update(['quantity'=>$request->quantity,
                   'product_id'=>auth()->user()->id,

          ])){

          }
          }

          public function destroy($id){

                  $del = Cart::find($id);
                  $del->delete();




        }
}
