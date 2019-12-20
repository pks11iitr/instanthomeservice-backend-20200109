<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class ProductsController extends Controller
{
    public function index(Request $request){
        $sel = Products::all();
        return view('siteadmin.products',['sel'=>$sel]);
    }
    public function detail(Request $request,$id){
        $det = Products::where('id',$id)->first();
        return view('siteadmin.productsdetail',['det'=>$det]);
    }
    public function create(Request $request){
        $allcategories=Category::get();
        return view('siteadmin.productsadd', ['allcategories'=>$allcategories]);
    }
    public function store(Request $request){

        if(isset($request->productsimage)){
            $file=$request->productsimage->path();

            $name=str_replace(' ', '_', $request->productsimage->getClientOriginalName());

            $path='products/'.$name;

            Storage::put($path, $file);
        }else{
            $path=null;
        }
        Products::create(['name' => $request->name,
            'company' => $request->company,
            'price' => $request->price,
            'cut_price' => $request->cut_price,
            'image' => $path,
            'size' => $request->size,
            'isactive' =>$request->isactive,
            'rating' => $request->rating,
            'categoryid' => $request->categoryid,
            'description' => $request->description,
            'in_the_box' => $request->inthebox]);

        return redirect(route('products.list'));
    }
    public function edit(Request $request,$id){
        $product = Products::find($id);
        $allcategorys = Category::get();
        return view('siteadmin.productsedit',['product'=>$product,'allcategorys'=>$allcategorys]);
    }
    public function update(Request $request,$id){
        $product=Products::findOrFail($id);
        if(isset($request->productsimage)) {
            $file = $request->productsimage->path();

            $name = str_replace(' ', '_', $request->productsimage->getClientOriginalName());

            $path = 'products/' . $name;

            Storage::put($path, $file);
        }else{
            $path=DB::raw('image');
        }


        $product->update(['name' => $request->name,
            'company' => $request->company,
            'price' => $request->price,
            'cut_price' => $request->cut_price,
            'image' => $path,
            'size' => $request->size,
            'isactive' =>$request->isactive,
            'rating' => $request->rating,
            'categoryid' => $request->categoryid,
            'description' => $request->description,
            'in_the_box' => $request->inthebox]);



        return redirect(route('products.list'));
    }
}
