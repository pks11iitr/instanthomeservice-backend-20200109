<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Controller;
use App\Models\Order_items;
use App\Models\Orders;
use App\User;
use Illuminate\Http\Request;
use DB;
class OrdersController extends Controller
{
    public function index(Request $request){
        $sel = Orders::where('status','=','new')->OrWhere('status','=','assigned')->get();
        return view('siteadmin.orders',['sel'=>$sel]);
    }
    public function details(Request $request,$id){
        $order = Orders::with(['details.product','time'])->findOrFail($id);
//        echo '<pre>';
//        print_r($order->toArray());die;
        $lists = User::role('vendor')->get();
        return view('siteadmin.openorderitems',['order'=>$order,'lists'=>$lists]);
    }
    public function completed(Request $request){
        $sel = Orders::where('status','=','completed')->orWhere('status','=','accepted')->get();
        return view('siteadmin.completedorders',['sel'=>$sel]);
    }
    public function inprocess(Request $request){
        $sel = Orders::where('status','=','processing')->orWhere('status','=','paid')->get();
        return view('siteadmin.inprocessorders',['sel'=>$sel]);
    }
    public function cancelled(Request $request){
        $sel = Orders::where('status','=','cancelled')->get();
        return view('siteadmin.cancelledorders',['sel'=>$sel]);
    }
}
