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

    public function changestatus(Request $request, $id){
        $order_item=Order_items::findOrFail($id);
        switch($request->type){
            case 'returned': if($order_item->order_status=='returnrequest'){
                $order_item->order_status='returned';
                $order_item->save();
                return redirect()->back()->with('success', 'Order status has been changed');
            }
            case 'completed': if($order_item->order_status=='delivered'){
                $order_item->order_status='completed';
                $order_item->save();
                return redirect()->back()->with('success', 'Order status has been changed');
            }
            case 'processing': if($order_item->order_status=='paid'){
                $order_item->order_status='processing';
                $order_item->save();
                return redirect()->back()->with('success', 'Order status has been changed');
            }
            case 'delivered': if($order_item->order_status=='processing'){
                $order_item->order_status='delivered';
                $order_item->save();
                return redirect()->back()->with('success', 'Order status has been changed');
            }
            default:break;
        }
        return redirect()->back()->with('error', 'Order status cannot be changed');

    }
}
