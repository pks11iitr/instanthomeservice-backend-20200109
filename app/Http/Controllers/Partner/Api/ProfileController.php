<?php

namespace App\Http\Controllers\Partner\Api;

use App\Models\Agreement;
use App\Models\Category;
use App\Models\TimeSlot;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function services(Request $request){
        $user=auth()->user();
        $services=Category::active()->where('parent', null)->get();
        $servicesselected=[];
        foreach($user->services as $s){
            $servicesselected[$s->title]=['id'=>$s->id, 'ischecked'=>1];
        }
        foreach($services as $s){
            if(!isset($servicesselected[$s->title]))
                $servicesselected[$s->title]=['id'=>$s->id, 'ischecked'=>0];
        }
        return [
            'services'=>$servicesselected
        ];
    }


    public function addServices(Request $request){
        $request->validate([
            'service'    =>'required|integer|min:1',
        ]);
        $user=auth()->user();
        $user->services()->syncWithoutDetaching([$request->service]);
        return [
            'status'=>'success',
            'message'=>'Services has been updated'
        ];
    }
    public function delServices(Request $request){
        $request->validate([
            'service'    =>'required|integer|min:1',
        ]);
        $user=auth()->user();
        $user->services()->detach([$request->service]);
        return [
            'status'=>'success',
            'message'=>'Services has been updated'
        ];
    }

    public function addTime(Request $request){
        $request->validate([
            'time'    =>'required|integer|min:1',
        ]);
        $user=auth()->user();
        $user->times()->syncWithoutDetaching([$request->time]);
        return [
            'status'=>'success',
            'message'=>'Times has been updated'
        ];
    }
    public function delTime(Request $request){
        $request->validate([
            'time'    =>'required|integer|min:1',
        ]);
        $user=auth()->user();
        $user->times()->detach([$request->time]);
        return [
            'status'=>'success',
            'message'=>'Times has been updated'
        ];
    }



    public function times(Request $request){
        $user=auth()->user();
        $times=TimeSlot::active()->get();
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
            'walletbalance'=>Wallet::balance($user->id),
            'is_available'=>$user->is_available
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
    public function acceptAggrement(Request $request){
        $user=auth()->user();
        $user->	agreement_signed=true;

        if($user->save()){
            return [
                'status'=>'success',
                'message'=>'Aggreement has been accepted'
            ];
        }

        return [
            'status'=>'failed',
            'message'=>'Profile update failed'
        ];

    }

    public function getAggrementDetails(Request $request){
        $user=auth()->user();
        $agreement=Agreement::orderBy('id', 'desc')->first();
        if($user->agreement_signed){

            return [
                'status'=>'signed',
                'url'=>$agreement->doc_path,
            ];
        }else{
            return [
                'status'=>'notsigned',
                'url'=>$agreement->doc_path,
            ];
        }
    }


}

