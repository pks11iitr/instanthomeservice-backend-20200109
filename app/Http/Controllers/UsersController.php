<?php

namespace App\Http\Controllers;
use App\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    function users(Request $request){
        $sel = users::all();
        return view('users',['sel'=>$sel]);
    }
    function usersdetail(Request $request,$id){
        $det = users::where('id',$id)->first();
        return view('usersdetail',['det'=>$det]);
    }
}
