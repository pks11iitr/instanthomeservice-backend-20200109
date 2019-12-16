<?php

namespace App\Http\Controllers;
use App\Permission_user;
use Illuminate\Http\Request;

class PermissionuserController extends Controller
{
    function permissionuser(Request $request){
        $sel = permission_user::all();
        return view('permissionuser',['sel'=>$sel]);
    }
}
