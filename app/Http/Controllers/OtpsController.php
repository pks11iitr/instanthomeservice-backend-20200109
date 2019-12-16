<?php

namespace App\Http\Controllers;
use App\Otps;
use Illuminate\Http\Request;

class OtpsController extends Controller
{
    function otps(){
        $sel = otps::all();
        return view('otps',['sel'=>$sel]);
    }
}
