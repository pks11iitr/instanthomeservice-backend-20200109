<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Partners;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index(Request $request){
        $banner=Banner::active()->get();
        $categories=Category::active()->where('parent', null)->get();
        return compact('banner','categories');
    }
}
