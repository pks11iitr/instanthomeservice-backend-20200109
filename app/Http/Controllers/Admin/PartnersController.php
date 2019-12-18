<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Partners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class PartnersController extends Controller
{
    public function index(Request $request){
        $sel = Partners::all();
        return view('siteadmin.partners',['sel'=>$sel]);
    }
    public function create(Request $request){
        return view('siteadmin.partnersadd');
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

        return redirect(route('partners.list'));
    }
    public function edit(Request $request,$id){
        $partner = Partners::find($id);
        return view('siteadmin.partnersedit',['partner'=>$partner]);
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

        return redirect(route('partners.list'));
    }
}
