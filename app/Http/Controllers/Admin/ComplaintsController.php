<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintsController extends Controller
{
    public function index(Request $request){
        $complaints = Complaint::get();
        return view('siteadmin.complaints',compact('complaints'));
    }
    public function update(Request $request){
        $user = Complaint::findOrFail($request->user_id);
        $user->is_resolved = $request->is_resolved;
        $user->save();
        return 'success';
    }
}
