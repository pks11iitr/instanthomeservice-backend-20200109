<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //public $timestamps=false;
    protected $table='cart';

    protected $fillable=['quantity','product_id', 'userid', 'unique_id'];

    protected $hidden =['created_at','updated_at','deleted_at'];

    public function product(){
        return $this->belongsTo('App\Models\Products', 'product_id');
    }

    public static function cartitems($user, $unique_id){
        if($user){
            $cart = Cart::with('product')->where('userid', $user->id)->get();
        }else if($unique_id){
            $cart = Cart::with('product')->where('unique_id', $unique_id)->get();
        }else{
            $cart=[];
        }

        $totalitems=0;
        $totalcost=0;
        $text='';
        foreach($cart as $c){
            $totalitems=$totalitems+$c->quantity;
            if(!empty($c->product->price)){
                $totalcost=$totalcost+$c->product->price*$c->quantity;
            }else{
                $text='Final cost after inspection';
            }
        }
        return [
            'totalitems'=>$totalitems,
            'totalcost'=>$totalcost
        ];
    }

    public static function remove($user, $did){
        if($user){
            Cart::where('userid', $user->id)->delete();
        }else if($did){
            Cart::where('unique_id', $did)->delete();
        }
    }

}
