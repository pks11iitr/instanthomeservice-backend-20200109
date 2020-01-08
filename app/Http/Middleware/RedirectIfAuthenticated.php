<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            /*
             * uncomment below line to view
             * default logged in page
             */
            //return redirect('/home');

            return $this->redirectTo();
        }

        return $next($request);
    }

    public function redirectTo(){
        if(auth()->user()->status==1){
            foreach(config('allowedusers.admins') as $key=>$value){
                if(auth()->user()->hasRole($key)){
                    return redirect(route($value));
                }
            }
            abort(401);
        }else if(auth()->user()->status==0){
            Auth::logout();
            Session::flash('error', 'Account is not active');
            return redirect(route('login'));
        }else if(auth()->user()->status==2){
            Auth::logout();
            Session::flash('error', 'Account has been blocked');
            return redirect(route('login'));
        }
    }
}
