<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Controller;
use App\Models\Order_items;
use App\Models\Orders;
use Illuminate\Http\Request;
use DB;
class OrdersController extends Controller
{
    public function index(Request $request){
        $sel = DB::table('orders')
            ->join('users','users.id','=','orders.user_id')
            ->select('orders.*','users.name','users.mobile')
            ->get();
        return view('siteadmin.orders',['sel'=>$sel]);
    }
    public function detail(Request $request,$id){
        $details = Order_items::where('order_id',$id)->get();
        return view('siteadmin.orderitems',['details'=>$details]);
    }
    public function status(Request $request,$id){
        $emp=Order_items::find($id);
        if($emp->order_status==processing)
            $emp->status=0;
        else
            $emp->status=processing;
        $emp->save();
        return redirect()->back();
    }
}
