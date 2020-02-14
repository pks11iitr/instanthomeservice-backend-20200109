<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Wallet;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\JWTAuth;

class ProfileController extends Controller
{

    public function __construct(Auth $auth, JWTAuth $jwt)
    {
        $this->jwt=$jwt;
        $this->auth=$auth;
    }

    public function updateAddress(Request $request){
        $user=$this->auth->user();

        $user->address=$request->address;
        $user->lat=$request->lat;
        $user->lang=$request->lang;
        if(!$user->save()){
            return response()->json([
                'message'=>'some error occurred',
                'errors'=>[

                ],
            ], 404);
        }
        return [
            'message'=>'Address has been updated'
        ];
    }


    public function updateProfile(Request $request){
        $user=$this->auth->user();

        $user->address=$request->address;
        if(!$user->save()){
            return response()->json([
                'message'=>'some error occurred',
                'errors'=>[

                ],
            ], 404);
        }
        return [
            'message'=>'Address has been updated'
        ];
    }

    public function getProfile(Request $request){
        $user=auth()->user();
        if($user)
        return array_merge($user->only('name', 'email', 'mobile', 'image','is_available'), ['walletbalance'=>Wallet::balance($user->id)]);
    }

    public function setProfile(Request $request){
        $request->validate([
            'image'=>'required|image',
            'name'=>'required|max:50',
            'email'=>'required|email'
        ]);
        $user=auth()->user();
        if(isset($request->image)){
            $file=$request->image->path();

            $name=str_replace(' ', '_', $request->image->getClientOriginalName());

            $path='profile/'.$name;

            Storage::put($path, file_get_contents($file));
        }else{
            $path=DB::raw('image');
        }
        if($user->update(array_merge($request->only('name', 'email'), ['image'=>$path]))){
            return [
                'status'=>'success',
                'message'=>'User profile has been uploaded',
                'user'=>$user->only('name', 'email', 'mobile', 'image')
            ];
        }else{
            return [
                'status'=>'failed',
                'message'=>'Profile Update failed',
                'user'=>''
            ];
        }


    }

}
