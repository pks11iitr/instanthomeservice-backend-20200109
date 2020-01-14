<?php

namespace App\Http\Controllers\Auth\Api;
use App\Models\Cart;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\OTPModel;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth, JWTAuth $jwt)
    {
        $this->auth=$auth;
        $this->jwt=$jwt;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile' => ['required', 'integer', 'digits:10'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['mobile'])
        ]);
    }


    public function login(Request $request){
        $this->validator($request->toArray())->validate();
        $user=$this->ifUserExists($request->mobile);
        if(!$user){
            if($user = $this->create($request->all())){
                //event(new Registered($user));
                //sendotp
               $user->assignRole('customer');
               OTPModel::createOTP($user->id, 'login');
            }
        }else if(!in_array($user->status, [0 , 1])){
            //send OTP
            return response()->json([
                'message'=>'invalid login attempt',
                'errors'=>[

                ],
            ], 401);
        }else{
            if(empty(array_intersect($user->getRoles(), config('allowedusers.apiusers')))){
                return response()->json([
                    'message'=>'invalid login attempt',
                    'errors'=>[

                    ],
                ], 401);
            }
            OTPModel::createOTP($user->id, 'login');
        }
        return [
            'message'=>'Please verify OTP to continue'
        ];


    }

    protected function ifUserExists($mobile){
        return (User::where('mobile', $mobile)->first())??false;
    }


    //verify OTP for authentication
    public function verifyOTP(Request $request){
        $this->validate($request, [
            'mobile' => ['required', 'integer', 'digits:10'],
            'otp' => ['required', 'integer'],
        ]);

        $unique_id=$request->did??'';
        $user=User::where('mobile', $request->mobile)->first();

        if(!$user){
            return response()->json([
                'message'=>'invalid login attempt',
                'errors'=>[
                ],
            ], 404);
        }else if(!($user->status==0 || $user->status==1)){
            return response()->json([
                'message'=>'account is not active',
                'errors'=>[

                ],
            ], 401);
        }

        if(!OTPModel::verifyOTP($user->id, 'login', $request->otp)){
            return response()->json([
                'message'=>'Incorrect OTP',
                'errors'=>[

                ],
            ], 401);
        }

        //activate user if not activated
        if($user->status==0){
            $user->status=1;
            $user->save();
        }

        //update cart items

        if($user && $unique_id){
            Cart::where('userid', $user->id??null)
                ->orWhere('unique_id', $unique_id)
                ->update(['userid'=>$user->id??null, 'unique_id'=>$unique_id]);
        }

        return [
            'message'=>'Login Successfull',
            'token'=>$this->jwt->attempt(['password'=>$request->mobile, 'mobile'=>$request->mobile])
        ];

    }

    public function home(Request $request){
        $user=$this->auth->user();
        return ['message'=>'user home page'];
    }


}
