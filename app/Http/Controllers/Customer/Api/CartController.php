<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Size;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
class CartController extends Controller
{

      public function store(Request $request){
          $request->validate([
  				'quantity'=>'required|integer|min:0',
                'product_id'=>'required|integer|min:1',
  				]);

          $token=$request->bearerToken();
          Auth::guard('api')->setToken($token);
          $user=  Auth::guard('api')->user();
          $unique_id=$request->did;

          if($user && $unique_id){
              Cart::where('userid', $user->id)
                  ->orWhere('unique_id', $unique_id)
                  ->update(['userid'=>$user->id, 'unique_id'=>$unique_id]);
          }

          if($user){
              $cart = Cart::where('product_id',$request->product_id)
                            ->where('userid', $user->id)->first();
          }else if($request->did){
              $cart = Cart::where('product_id',$request->product_id)
                  ->where('unique_id', $unique_id)->first();
          }else{
              return [
                  'status'=>'failed',
                  'message'=>'Invalid Request'
              ];
          }


          if(!$cart){
              if($request->quantity>0){
                Cart::create([
                    'product_id'=>$request->product_id,
                    'quantity'=>$request->quantity,
                    'userid'=>$user->id??null,
                    'unique_id'=>$unique_id,
                ]);
              }

          }else{
            if($request->quantity>0){
              $cart->quantity=$request->quantity;
              if($user)
                   $cart->userid=$user->id;
              if($unique_id)
                   $cart->unique_id=$unique_id;
              $cart->save();
            }else{
              $cart->delete();
            }
          }

          return [
            'status'=>'success',
            'message'=>'Item has been added to cart'
          ];

      }

      public function getCartDetails(Request $request){

          $user=  Auth::guard('api')->user();
          $unique_id=$request->did;

          if($user && $unique_id){
              Cart::where('userid', $user->id??null)
                  ->orWhere('unique_id', $unique_id)
              ->update(['userid'=>$user->id??null, 'unique_id'=>$unique_id]);
          }

          if($user){
              $cart = Cart::with('product')->where('userid', $user->id)->get();
          }else if($request->did){
              $cart = Cart::with('product')->where('unique_id', $unique_id)->get();
          }else{
              $cart=[];
          }

          return [
              'status'=>'success',
              'cart'=>$cart
          ];
      }
}
