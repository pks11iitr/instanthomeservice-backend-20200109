<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    function index(Request $request){
        $sel = User::role('admin')->get();
        return view('siteadmin.users',['sel'=>$sel]);
    }
    function detail(Request $request,$id){
        $det = User::where('id',$id)->first();
        return view('siteadmin.usersdetail',['det'=>$det]);
    }
}
