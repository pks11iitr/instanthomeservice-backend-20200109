<?php

namespace App\Http\Controllers;
use App\Permission_role;
use Illuminate\Http\Request;

class PermissionroleController extends Controller
{
    function permissionrole(){
        $sel = permission_role::all();
        return view('permissionrole',['sel'=>$sel]);
    }
}
