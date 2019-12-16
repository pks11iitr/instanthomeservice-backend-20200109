<?php

namespace App\Http\Controllers;
use App\Partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PartnersController extends Controller
{
    public function index(Request $request){
        $sel = Partners::all();
        return view('partners',['sel'=>$sel]);
    }
    public function create(Request $request){
        return view('partnersadd');
    }
    public function store(Request $request){

        if(isset($request->partnersimage)){
            $file=$request->partnersimage->path();

            $name=str_replace(' ', '_', $request->partnersimage->getClientOriginalName());

            $path='partners/'.$name;

            Storage::put($path, $file);
        }else{
            $path=null;
        }
        Partners::create(['name' => $request->name,
            'image' => $path,
            'isactive' => $request->isactive]);

        return redirect('partners');
    }
    public function edit(Request $request,$id){
        $partner = Partners::find($id);
        return view('partnersedit',['partner'=>$partner]);
    }
    public function update(Request $request,$id){

        $partner=Partners::findOrFail($id);
        if(isset($request->partnersimage)){
            $file=$request->partnersimage->path();

            $name=str_replace(' ', '_', $request->partnersimage->getClientOriginalName());

            $path='partners/'.$name;

            Storage::put($path, $file);

            $partner->update(['name' => $request->name,
                'image' => $path,
                'isactive'=>$request->isactive]);

        }else{
            $partner->update(['name' => $request->name,
                'isactive'=>$request->isactive]);
        }

        return redirect('partners');
    }
}
