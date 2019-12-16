<?php

namespace App\Http\Controllers;
use App\Role_user;

use Illuminate\Http\Request;

class RoleuserController extends Controller
{
    function roleuser(Request $request){
        $sel = role_user::all();
        return view('roleuser',['sel'=>$sel]);
    }
}
