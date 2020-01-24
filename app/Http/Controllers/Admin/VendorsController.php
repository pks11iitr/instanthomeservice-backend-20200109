<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Vendor;
use App\User;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    public function index(Request $request){
        $vendors = User::role('vendor')->where('agreement_signed','=',1)->get();
        return view('siteadmin.vendors',compact('vendors'));
    }
    public function update(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->status = $request->status;
        $user->save();
        return 'success';
    }
    public function agreementnot(Request $request){
        $agreementnot =User::role('vendor')->where('agreement_signed','=',0)->get();
        return view('siteadmin.agreementnot',compact('agreementnot'));
    }
    public function updatenot(Request $request){
        $user = User::findOrFail($request->user_id);
        $user->status = $request->status;
        $user->save();
        return 'success';
    }
}
