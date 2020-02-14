<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Partner\Api\OrderController;
use App\Models\Orders;
use App\Models\Products;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request){
        $users=User::role('customer')->count();
        $partners=User::role('vendor')->count();
        $services=Products::count();
        $totalorders=Orders::where('isbookingcomplete',1)->count();
        $completed=Orders::where('isbookingcomplete',1)->whereIn('status', ['completed','paid'])->count();
        $neworders=Orders::where('isbookingcomplete',1)->whereIn('status', ['new', 'assigned'])->count();
        $processing=Orders::where('isbookingcomplete',1)->whereIn('status', ['accepted','processing'])->count();
        $cancelled=Orders::where('isbookingcomplete',1)->whereIn('status', ['cancelled'])->count();
        $totalrevenue=Orders::where('isbookingcomplete',1)->where('status', 'paid')->select(DB::raw('sum(total_after_inspection) as total'))->get();
//        echo "<pre>";
//var_dump($totalrevenue);die;
        return view('siteadmin.dashboard', compact('users','partners','totalorders','completed','processing','cancelled','totalrevenue','neworders','services'));
    }
}
