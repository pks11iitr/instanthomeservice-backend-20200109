<?php

namespace App\Http\Controllers;
use App\Roles;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    function role(){
        $sel = roles::all();
        return view('role',['sel'=>$sel]);
    }
}
