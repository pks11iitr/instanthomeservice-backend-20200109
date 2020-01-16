<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request){

        $category=Category::active()->where('parent', null)->get()->toArray();

       return $category;

    }

    public function cateproduct(Request $request,$id){

        $user=  Auth::guard('api')->user();
        $unique_id=$request->did??null;

        if($user){
            $cart = Cart::where('userid', $user->id)->get();
        }else if($request->did){
            $cart = Cart::where('unique_id', $unique_id)->get();
        }else{
            $cart=[];
        }
        $carts=[];
        foreach($cart as $c){
            $carts[$c->product_id]=$c->quantity;
        }
        $category=Category::active()->with(['product'=>function($products){
          $products->where('isactive', true);
        }])->where('id',$id)->first();

        $i=0;
        $installation=[];
        $uninstallation=[];

        foreach($category->product as $p){
            if(isset($carts[$p->id])){
              $category->product[$i]->quantity=$carts[$p->id];
            }else{
              $category->product[$i]->quantity=0;
            }

            if($category->type==6){
                    if($i<3){
                        $installation[]=$p;
                    }else{
                        $uninstallation[]=$p;
                    }
            }
          $i++;
        }
      $category->installation=$installation;
      $category->uninstallation=$uninstallation;
      //$category->cart=$cart;
      return $category;
    }

    public function subcategory(Request $request, $id){
        $category=Category::active()->with('subcategories')->find($id);
        return $category;

    }
}
