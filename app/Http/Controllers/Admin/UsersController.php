<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    function users(Request $request){
        $sel = users::all();
        return view('siteadmin.users',['sel'=>$sel]);
    }
    function usersdetail(Request $request,$id){
        $det = users::where('id',$id)->first();
        return view('siteadmin.usersdetail',['det'=>$det]);
    }
}
