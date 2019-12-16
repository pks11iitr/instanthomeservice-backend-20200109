<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ProductsController extends Controller
{
    public function index(Request $request){
        $sel = products::all();
        return view('products',['sel'=>$sel]);
    }
    public function detail(Request $request,$id){
        $det = products::where('id',$id)->first();
        return view('productsdetail',['det'=>$det]);
    }
    public function create(Request $request){
        $allcategories=Products::get();
        return view('productsadd', ['allcategories'=>$allcategories]);
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
            'image' => $path,
            'size' => $request->size,
            'isactive' =>$request->isactive,
            'rating' => $request->rating,
            'categoryid' => $request->categoryid,
            'description' => $request->description,
            'in_the_box' => $request->inthebox]);

        return redirect('products');
    }
    public function edit(Request $request,$id){
        $product = Products::find($id);
        $allcategorys = Category::get();
        return view('productsedit',['product'=>$product,'allcategorys'=>$allcategorys]);
    }
    public function update(Request $request,$id){
        $product=Products::findOrFail($id);
        if(isset($request->productsimage)){
            $file=$request->productsimage->path();

            $name=str_replace(' ', '_', $request->productsimage->getClientOriginalName());

            $path='products/'.$name;

            Storage::put($path, $file);

            $product->update(['name' => $request->name,
                'company' => $request->company,
                'price' => $request->price,
                'image' => $path,
                'size' => $request->size,
                'isactive' =>$request->isactive,
                'rating' => $request->rating,
                'categoryid' => $request->categoryid,
                'description' => $request->description,
                'in_the_box' => $request->inthebox]);

        }else{
            $product->update(['name' => $request->name,
                'company' => $request->company,
                'price' => $request->price,
                'size' => $request->size,
                'isactive' =>$request->isactive,
                'rating' => $request->rating,
                'categoryid' => $request->categoryid,
                'description' => $request->description,
                'in_the_box' => $request->inthebox]);
        }

        return redirect('products');
    }
}
