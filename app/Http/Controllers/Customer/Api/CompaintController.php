<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Complaint;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompaintController extends Controller
{
    public function index(Request $request){
        $user=auth()->user();
        if($user){
            return Complaint::where('user_id', $user->id);
        }
        return [];

    }

    public function store(Request $request){
        $request->validate([
           'title'=>'required|string|max:150',
           'description'=>'required|string|max:1000',
           'attachment'=>'nullable|image',
            'order_id'=>'required|integer'
        ]);

        $user=auth()->user();
        if($user) {
            if (isset($request->attachment)) {
                $file = $request->attachment->path();

                $name = str_replace(' ', '_', $request->attachment->getClientOriginalName());

                $path = 'complaints/' . $name;

                Storage::put($path, file_get_contents($file));
            } else {
                $path = DB::raw('attachment');
            }

            if (Complaint::create(array_merge($request->only('title', 'description', 'order_id'), ['user_id' => auth()->user()->id, 'attachment'=>$path])))
                return [
                    'status' => 'success',
                    'message' => 'Your complaint has been submitted'
                ];
        }
        return [
            'status'=>'failed',
            'message'=>'Operation failed. Please try again'
        ];
    }


}
