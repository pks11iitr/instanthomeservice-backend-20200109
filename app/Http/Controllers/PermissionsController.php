<?php

namespace App\Http\Controllers;
use App\Permissions;
use Illuminate\Http\Request;

class PermissionsController extends Controller
{
    function permissions(){
        $sel = permissions::all();
        return view('permissions',['sel'=>$sel]);
    }
}
