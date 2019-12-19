<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use\App\Models\Banner;
use Storage;

class BannerController extends Controller
{
          public function index(Request $request){

            $banners=Banner::get();
            return view('siteadmin.bannerview',['banners'=>$banners]);

                }

                  public function create(Request $request){
                    return view('siteadmin.banneradd');

                    }


                    public function store(Request $request){

                      $request->validate([
                  			'isactive'=>'required',
                  			'doc_path'=>'required|image'

                      		]);

                      		$file=$request->doc_path->path();

                      		$name=str_replace(' ', '_', $request->doc_path->getClientOriginalName());

                      		$path='banner/'.$name;

                      		Storage::put($path, file_get_contents($file));

                      	   if(Banner::create([
                      					'isactive'=>$request->isactive,
                      					'doc_path'=>$path,

                      					])){
                      				return redirect()->route('banners.list')->with('success', 'Banner has been created');
                      		}

                      		return redirect()->back()->with('error', 'Banner create failed');


                      }
                      public function edit(Request $request,$id){
                        $banner = Banner::findOrFail($id);
                          return view('siteadmin.banneredit',['banner'=>$banner]);
                        }


                        public function update(Request $request,$id){

                          $request->validate([

            			             'isactive'=>'required'

            		               ]);
                                 $banner = Banner::findOrFail($id);
                  if($request->doc_path){
                        $file=$request->doc_path->path();

                      $name=str_replace(' ', '_', $request->doc_path->getClientOriginalName());

                      $path='banner/'.$name;

                      Storage::put($path, file_get_contents($file));

                  }else{
                      $path=DB::raw('doc_path');
                  }



          if($banner->update([

        			'isactive'=>$request->isactive,
                    'doc_path'=>$path
          ])){
                return redirect()->route('banners.list')->with('success', 'Banner has been updated');

          }
             	return redirect()->back()->with('error', 'Banner update failed');

                          }

  }
