<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OTPModel extends Model
{
    protected $table='otps';

    protected $fillable=['user_id', 'otp', 'type', 'expiry'];

    public static function createOTP($userid, $type){
        $rand=rand(1, 9).''.rand(1, 9).''.rand(1, 9).''.rand(1, 9).''.rand(1, 9).''.rand(1, 9);
        $otp=self::where('user_id', $userid)
                        ->where('isverified', false)
                        ->where('type', $type)
                        ->orderBy('id', 'desc')
                        ->first();
        if($otp){
            return $otp->otp;
        }
        $otp=self::create(['user_id'=>$userid, 'otp'=>$rand, 'type'=>$type, 'expiry'=>date('Y-m-d H:i:s')]);
        if($otp)
            return $otp->otp;

        return false;
    }

    public static function verifyOTP($userid, $type, $otp){
        $otpobj=self::where('user_id', $userid)->where('isverified', false)->where('type', $type)->orderBy('id', 'desc')->first();

        if(!$otpobj || $otpobj->otp!=$otp){
            return false;
        }

        $otpobj->isverified=true;
        if($otpobj->save())
            return true;

        return false;

    }

}
