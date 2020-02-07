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
        $sel = Orders::with(['time'])->where('status','=','new')->OrWhere('status','=','assigned')->get();
        return view('siteadmin.orders',['sel'=>$sel]);
    }
    public function details(Request $request,$id){
        $order = Orders::with(['details.product','time','vendors'])->findOrFail($id);

        $services=[];

        foreach($order->details as $d){
            $services[]=$d->product->category->parentcategory->id;
        }

//        echo '<pre>';
//        print_r($order->toArray());die;
        //var_dump($services);die;
        $lists = User::role('vendor')->with('services')->whereHas('services', function($service) use($services){
            $service->whereIn('user_services.service_id', $services);
        })->get();
        return view('siteadmin.openorderitems',['order'=>$order,'lists'=>$lists]);
    }
    public function completed(Request $request){
        $sel = Orders::with(['time'])->where('status','=','completed')->orWhere('status','=','accepted')->get();
        return view('siteadmin.completedorders',['sel'=>$sel]);
    }
    public function completedetails(Request $request,$id){
        $order = Orders::with(['details.product','time','vendors'])->findOrFail($id);

        $services=[];

        foreach($order->details as $d){
            $services[]=$d->product->category->parentcategory->id;
        }
        $lists = User::role('vendor')->with('services')->whereHas('services', function($service) use($services){
            $service->whereIn('user_services.service_id', $services);
        })->get();
        return view('siteadmin.completedetails',['order'=>$order,'lists'=>$lists]);
    }
    public function inprocess(Request $request){
        $sel = Orders::with(['time'])->where('status','=','processing')->orWhere('status','=','paid')->get();
        return view('siteadmin.inprocessorders',['sel'=>$sel]);
    }
    public function inprocessdetails(Request $request,$id){
        $order = Orders::with(['details.product','time','vendors'])->findOrFail($id);

        $services=[];

        foreach($order->details as $d){
            $services[]=$d->product->category->parentcategory->id;
        }
        $lists = User::role('vendor')->with('services')->whereHas('services', function($service) use($services){
            $service->whereIn('user_services.service_id', $services);
        })->get();
        return view('siteadmin.inprocessdetails',['order'=>$order,'lists'=>$lists]);
    }
    public function cancelled(Request $request){
        $sel = Orders::where('status','=','cancelled')->get();
        return view('siteadmin.cancelledorders',['sel'=>$sel]);
    }
}
