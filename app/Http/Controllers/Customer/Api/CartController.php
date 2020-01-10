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
          $unique_id=$request->token;

          $cart = Cart::where('product_id',$request->product_id)
              ->where(function($cart) use($user,$unique_id){
                  $cart->where('userid', $user->id??null)
                      ->orWhere('unique_id', $unique_id);
              })->first();

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
              $cart->size_id=$request->size;
              $cart->user_id=$user->id??null;
              $cart->unique_id=$unique_id??null;
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
          $token=$request->bearerToken();
          Auth::guard('api')->setToken($token);
          $user=  Auth::guard('api')->user();
          //var_dump($user);die;
          if($user){
              return $user->cart()->with(['product', 'sizeprice'])->get();
          }else{
              return Cart::where('unique_id', $request->did)->with(['product', 'sizeprice'])->get();
          }
      }
}
