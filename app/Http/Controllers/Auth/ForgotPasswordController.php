<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OTPModel;
use App\User;
use App\Services\SMS\Msg91;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
//        $response = $this->broker()->sendResetLink(
//            $this->credentials($request)
//        );
//
//        return $response == Password::RESET_LINK_SENT
//            ? $this->sendResetLinkResponse($request, $response)
//            : $this->sendResetLinkFailedResponse($request, $response);

        $user=User::where('mobile', $this->credentials($request))->first();
        if(!$user) {
            return redirect()->back()->with('error', 'invalid login attempt');
        }else if(!in_array($user->status, [0 , 1])){
            return redirect()->back()->with('error', 'Account has been blocked');
        }

        if($otp=OTPModel::createOTP($user->id, 'reset-password')){
            $msg=config('sms-templates.reset-otp');
            $msg=str_replace('{{otp}}', $otp, $msg);
            if(Msg91::send($request->mobile, $msg)){

            }
        }
        return redirect()->route('password.reset', ['token'=>'otp'])->with('success', 'OTP has been sent to registered mobile');
    }

    protected function validateEmail(Request $request)
    {
        $request->validate(['mobile' => ['required', 'integer', 'digits:10']]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('mobile');
    }
}
