<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorsController extends Controller
{
    public function index(Request $request){
        return view('siteadmin.vendors');
    }
}
