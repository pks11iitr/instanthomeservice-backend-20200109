<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponController extends Controller
{
    public function index(Request $request){
        $coupons =Coupon::get();
        return view('siteadmin.coupon',['coupons'=>$coupons]);
    }
    public function edit(Request $request,$id){
        $couponedit =Coupon::find($id);
        return view('siteadmin.couponedit',['couponedit'=>$couponedit]);
    }
    public function update(Request $request,$id){
        $couponedit =Coupon::find($id);
        $couponedit->update($request->only(['code','title','amount','type','max_usage','validity']));
        return redirect(route('coupons.list'))->with('success','coupon has been updated');
    }
}
