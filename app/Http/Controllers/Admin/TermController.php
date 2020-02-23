<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TermController extends Controller
{
    public function privacy(Request $request){
        return view('privacy');
    }
    public function about(Request $request){
        return view('about');
    }
    public function term(Request $request){
        return view('term');
    }
}
