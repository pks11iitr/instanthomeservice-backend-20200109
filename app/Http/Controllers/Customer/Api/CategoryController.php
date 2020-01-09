<?php

namespace App\Http\Controllers\Customer\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;

class CategoryController extends Controller
{
    public function index(Request $request){

        $category=Category::active()->where('parent', null)->get()->toArray();

       return $category;

    }

    public function cateproduct(Request $request,$id){

      $product=Products::active()->with(['category', 'sizeprice'])->where('categoryid',$id)->get()->toArray();

      return $product;
    }

    public function subcategory(Request $request, $id){
        $category=Category::active()->with('subcategories')->find($id);
        return $category;

    }
}
