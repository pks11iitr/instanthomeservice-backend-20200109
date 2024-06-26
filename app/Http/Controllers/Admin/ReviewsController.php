<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index(Request $request){
        $reviews = Review::with(['user', 'order'])->get();
        return view('siteadmin.reviews',compact('reviews'));
    }
}
