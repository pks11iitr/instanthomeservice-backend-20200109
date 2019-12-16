<?php

namespace App\Http\Controllers;
use App\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function cart(Request $request){
        $sel = cart::all();
        return view('cart',['sel'=>$sel]);
    }
}
