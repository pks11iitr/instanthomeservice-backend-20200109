<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CategoryController extends Controller
{
    public function index(Request $request){
        $sel = Category::with('parentcategory')->get();
        return view('siteadmin.category',['sel'=>$sel]);
    }
    public function create(Request $request){
        $sel = Category::get();
        return view('siteadmin.categoryadd', ['categories'=>$sel]);
    }
    public function store(Request $request){

        if(isset($request->categoryimage)){
            $file=$request->categoryimage;
            $file2=$request->rate_url;

            $name=str_replace(' ', '_', $request->categoryimage->getClientOriginalName());
            $name2=str_replace(' ', '_', $request->rate_url->getClientOriginalName());

            $path='category/'.$name;
            $path2='category/'.$name2;

            Storage::put($path, file_get_contents($file));
            Storage::put($path2, file_get_contents($file2));
        }else{
            $path=null;
        }
        Category::create(['title' => $request->title,
            'description' => $request->description,
            'image' => $path,
            'rate_url'=>$path2,
            'parent' => $request->parent,
            'istop' => $request->istop,
            'isactive'=>$request->isactive]);

        return redirect(route('category.list'));
    }

    public function edit(Request $request, $id){
        $category = Category::find($id);
        $allcategories = Category::get();
        return view('siteadmin.categoryedit',['category'=>$category,'allcategories'=>$allcategories]);
    }

    public function update(Request $request, $id){

        $category=Category::findOrFail($id);
        if(isset($request->categoryimage)){
            $file=$request->categoryimage;
            $file2=$request->rate_url;

            $name=str_replace(' ', '_', $request->categoryimage->getClientOriginalName());
            $name2=str_replace(' ', '_', $request->rate_url->getClientOriginalName());

            $path='category/'.$name;
            $path2='category/'.$name2;

            Storage::put($path, file_get_contents($file));
            Storage::put($path2, file_get_contents($file2));

            $category->update(['title' => $request->title,
                'description' => $request->description,
                'image' => $path,
                'rate_url'=>$path2,
                'parent' => $request->parent,
                'istop' => $request->istop,
                'isactive'=>$request->isactive]);

        }else{
            $category->update(['title' => $request->title,
                'description' => $request->description,
                'parent' => $request->parent,
                'istop' => $request->istop,
                'isactive'=>$request->isactive]);
        }

        return redirect(route('category.list'));
    }

}
