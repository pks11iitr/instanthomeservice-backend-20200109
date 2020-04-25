<?php

namespace App\Http\Controllers;

use App\Models\CustomerQuery;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index(Request $request){
        return view('welcome');
    }


    public function submitQuery(Request $request){
        $request->validate([
            'name'=>'required',
            'mobile'=>'required',
            'email'=>'required',
            'description'=>'required',
        ]);

        CustomerQuery::create($request->only(['name', 'mobile','email', 'description']));

        return redirect()->back()->with('success', 'Your details has been submitted. We will contact you shortly');

    }
}
