<?php

namespace App\Http\Controllers\Partner\Api;

use App\Models\Category;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function services(Request $request){
        $user=auth()->user();
        $services=Category::active()->where('parent', null)->get();
        $servicesselected=[];
        foreach($user->services as $s){
            $servicesselected[$s->name]=['id'=>$s->id, 'ischecked'=>1];
        }
        foreach($services as $s){
            if(!isset($servicesselected[$s->name]))
                $servicesselected[$s->name]=['id'=>$s->id, 'ischecked'=>0];
        }
        return [
            'services'=>$servicesselected
        ];
    }

    public function updateServices(Request $request){
        $request->validate([
            'services'    =>'nullable|array|min:0',
            'services.*'  =>'required|integer',
        ]);
        $user=auth()->user();
        if($user){
            $sids=[];
            if(!empty($request->services)){
                foreach($request->services as $s){
                    $sids[]=$s;
                }
            }
            $user->services()->sync($sids);
            return [
                'status'=>'success',
                'message'=>'Services has been updated'
            ];
        }
        return [
            'status'=>'failed',
            'message'=>'Services update failed'
        ];

    }

    public function times(Request $request){
        $user=auth()->user();
        $times=TimeSlot::active()->where('parent', null)->get();
        $servicesselected=[];
        foreach($user->times as $s){
            $servicesselected[$s->name]=['id'=>$s->id, 'ischecked'=>1];
        }
        foreach($times as $s){
            if(!isset($servicesselected[$s->name]))
                $servicesselected[$s->name]=['id'=>$s->id, 'ischecked'=>0];
        }
        return [
            'times'=>$servicesselected
        ];
    }


    public function updateTimes(Request $request){
        $request->validate([
            'times'    =>'nullable|array|min:0',
            'times.*'  =>'required|integer',
        ]);
        $user=auth()->user();
        if($user){
            $sids=[];
            if(!empty($request->times)){
                foreach($request->times as $s){
                    $sids[]=$s;
                }
            }
            $user->services()->sync($sids);
            return [
                'status'=>'success',
                'message'=>'Times has been updated'
            ];
        }
        return [
            'status'=>'failed',
            'message'=>'Times update failed'
        ];
    }

    public function updateAvailability(Request $request){
        $request->validate([
            'isavailable'=>'required|in:0,1'
        ]);

        $user=auth()->user();
        $user->is_available=$request->isavailable;
        if($user->save()){
            return [
                'status'=>'success',
                'message'=>'Availablity has been updated'
            ];
        }
        return [
            'status'=>'success',
            'message'=>'Availablity update failed'
        ];
    }

    public function profile(Request $request){
        $user=auth()->user();
        return [
            'name'=>$user->name??'',
            'email'=>$user->email??'',
            'mobile'=>$user->mobile??'',
            'image'=>$user->image??'',
        ];
    }

    public function updateProfile(Request $request){
        $request->validate([
            'image'=>'nullable|image',
            'name'=>'required|string|max:100',
            'email'=>'nullable|email'
        ]);

        $user=auth()->user();
        if($user->update(array_merge($request->only('name', 'email'), ['image'=>$path]))){
            return [
                'status'=>'success',
                'message'=>'Profile has been updated'
            ];
        }

        return [
            'status'=>'failed',
            'message'=>'Profile update failed'
        ];

    }
}

