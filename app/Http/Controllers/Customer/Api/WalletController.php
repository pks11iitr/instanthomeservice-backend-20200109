<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    public function history(Request $request){
        $history=Wallet::where('iscomplete', true)->get();
        return compact('history');
    }

    public function addMoney(Request $request){
        $request->validate([
            'amount'=>'required|integer|min:1'
        ]);

        $user=auth()->user();
        if($user){
            $wallet=Wallet::create(['refid'=>date('YmdHis'), 'type'=>'Credit', 'amount'=>$request->amount, 'description'=>'Wallet Recharge','user_id'=>$user->id]);

            $response=$this->pay->generateorderid([
                "amount"=>$wallet->amount*100,
                "currency"=>"INR",
                "receipt"=>$wallet->refid.'',
            ]);
            $responsearr=json_decode($response);
            if(isset($responsearr->id)){
                $wallet->razor_order_id=$responsearr->id;
                $wallet->order_id_response=$response;
                $wallet->save();
                return [
                    'status'=>'success',
                    'data'=>[
                        'id'=>$wallet->id,
                        'order_id'=>$wallet->order_id,
                        'amount'=>$wallet->amount
                    ]
                ];
            }else{
                return response()->json([
                    'status'=>'failed',
                    'message'=>'Payment cannot be initiated',
                    'data'=>[
                    ],
                ], 200);
            }
        }

        return response()->json([
            'status'=>'failed',
            'message'=>'logout',
            'data'=>[
            ],
        ], 200);

    }

    public function verifyRecharge(Request $request){
        $user=auth()->user();
        $wallet=Wallet::where('order_id', $request->razorpay_order_id)->firstOrFail();
        $paymentresult=$this->pay->verifypayment($request->all());
        if($paymentresult){
            $wallet->payment_id=$request->razorpay_payment_id;
            $wallet->payment_id_response=$request->razorpay_signature;
            $wallet->iscomplete=true;
            $wallet->save();
            return response()->json([
                'status'=>'success',
                'message'=>'Payment is successfull',
                'errors'=>[

                ],
            ], 200);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'Payment is not successfull',
                'errors'=>[

                ],
            ], 200);
        }
    }

    public function getWalletBalance(Request $request){
        $user=auth()->user();
        if($user){
            return ['balance'=>Wallet::balance($user->id)];
        }
    }
}
