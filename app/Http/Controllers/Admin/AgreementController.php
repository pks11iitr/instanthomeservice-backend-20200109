<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agreement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Storage;
class AgreementController extends Controller
{
    public function view(Request $request){
        $agreement=Agreement::orderBy('id','desc')->first();
        return view('siteadmin.agreement-view',compact('agreement'));
    }

    public function form(Request $request){
        return view('siteadmin.agreement-form');
    }

    public function upload(Request $request){
        $request->validate([
            'agreement'=>'required|mimes:pdf'
        ]);
        if(isset($request->agreement)){

            $name=str_replace(' ', '_', $request->agreement->getClientOriginalName());
            $name=''.rand(111,999).$name;

            $path = $request->file('agreement')->storeAs(
                'agreement', $name
            );
            //echo Storage::path('aggreement/'."'".$name."'");die;
            //rename(Storage::path('agreement/'."'".$name."'"),Storage::path($path));

            Agreement::create(['doc_path'=>$path]);
            return redirect()->back()->with('success', 'Pdf has been uploaded');
        }
    }
}
