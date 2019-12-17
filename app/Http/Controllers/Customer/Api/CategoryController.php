<?php

namespace App\Http\Controllers\Customer\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;

class CategoryController extends Controller
{
    public function index(Request $request){

        $category=Category::get();

       return $category;

    }

    public function cateproduct(Request $request,$id){

      $product=Products::with('category')->where('categoryid',$id)->first();

      return $product;
    }
}
