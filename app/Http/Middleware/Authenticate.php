<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $result=$this->auth->shouldUse($guard);
                $check=$this->checkForValidUser($guard);
                if($check){
                    throw new AuthenticationException(
                        'Unauthenticated.', $guards, $this->redirectTo($request)
                    );
                }
                return $result;
            }
        }

        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }

    public function checkForValidUser($guard){
        if($guard=='api'){
            if(auth()->user()->status==1) {
                return null;
            }else if(auth()->user()->status==0){
                return ['message'=>'account is not active'];
            }else if(auth()->user()->status==2){
                return ['message'=>'account has been blocked'];
            }
        }else{
            if(auth()->user()->status==1) {
                return null;
            }else if(auth()->user()->status==0){
                Auth::logout();
                Session::flash('error', 'Account is not active');
                return route('login');
            }else if(auth()->user()->status==2){
                Auth::logout();
                Session::flash('error', 'Account has been blocked');
                return route('login');
            }
        }

    }
}
