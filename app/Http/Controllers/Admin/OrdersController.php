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
        $sel = Orders::with(['time'])->where('isbookingcomplete', true)->where('status','=','new')->OrWhere('status','=','assigned')->orderBy('created_at', 'desc')->get();
        return view('siteadmin.orders',['sel'=>$sel]);
    }

    public function completed(Request $request){
        $sel = Orders::where('isbookingcomplete', true)->where('status','=','completed')->orWhere('status','=','paid')->orderBy('created_at', 'desc')->get();
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
        $sel = Orders::where('isbookingcomplete', true)->where('status','=','processing')->orWhere('status','=','accepted')->orderBy('created_at', 'desc')->get();
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
        $sel = Orders::where('isbookingcomplete', true)->where('status','=','cancelled')->orderBy('created_at', 'desc')->get();
        return view('siteadmin.cancelledorders',['sel'=>$sel]);
    }

    public function details(Request $request,$id){
        $order = Orders::with(['details.product','time','vendors'])->findOrFail($id);

        $services=[];

        foreach($order->details as $d){
            if(isset($d->product->category->parentcategory->id))
                $services[]=$d->product->category->parentcategory->id;
        }
        $user=$order->user;

        $vendors=[];
        foreach($order->vendors as $v){
            $vendors[$v->id]=$v->pivot->status;
        }
        if(!empty($order->lat) && !empty($order->lang)){
            $haversine = "(6371 * acos(cos(radians($order->lat))
                     * cos(radians(users.lat))
                     * cos(radians(users.lang)
                     - radians($order->lang))
                     + sin(radians($order->lat))
                     * sin(radians(users.lat))))";

            $lists = User::role('vendor')
                ->with('services')
                ->whereHas('services', function($service) use($services){
                    $service->whereIn('user_services.service_id', $services)->select();
                })->select('users.*', DB::raw("$haversine as distance"))->orderBy('distance', 'asc')->get();
        }else{
            $lists = User::role('vendor')
                ->with('services')
                ->whereHas('services', function($service) use($services){
                    $service->whereIn('user_services.service_id', $services)->select();
                })->select('users.*')->get();
        }

//        echo "<pre>";
//        print_r($lists->toArray());die;
        return view('siteadmin.openorderitems',['order'=>$order,'lists'=>$lists, 'vendors'=>$vendors]);
    }

    public function assignToVendor(Request $request, $id,$vid){

        $order=Orders::findOrFail($id);
        if($order->status=='new'){
            $order->status='assigned';
            $order->save();
            $order->vendors()->attach([$vid=>['status'=>'new']]);
            return redirect()->back()->with('success', 'Order has been assigned to vendor.');
        }
        return redirect()->back()->with('error', 'New vendor cannot be assigned at this stage. Revoke currect vendor first');
    }

    public function revokeVendor(Request $request, $id, $vid){
        $order=Orders::findOrFail($id);
        if($order->status=='assigned'){
            $order->status='new';
            $order->save();
            $order->vendors()->detach($vid);
            $order->vendors()->attach([$vid=>['status'=>'expired']]);
            return redirect()->back()->with('success', 'Order has been assigned to vendor.');
        }
        return redirect()->back()->with('error', 'Order cannot be revoked at this stage');

    }

}
