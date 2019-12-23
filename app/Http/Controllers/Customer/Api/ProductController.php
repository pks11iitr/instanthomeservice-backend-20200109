<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function details(Request $request, $id){
        $product=Products::active()->where('id', $id)->with('sizeprice')->firstOrFail();
        return $product;
    }
}
