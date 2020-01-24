<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index(Request $request){
        $customers = User::role('customer')->get();
        return view('siteadmin.customers',compact('customers'));
    }
}
