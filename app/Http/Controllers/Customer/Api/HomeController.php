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
        $maincategories=Category::active()->where('parent', null)->get();
        //$smallcategories=Category::active()->where('istop', false)->limit(6)->get();
        $partners=Partners::active()->get();
        return compact('banner','maincategories', 'partners');
    }
}
