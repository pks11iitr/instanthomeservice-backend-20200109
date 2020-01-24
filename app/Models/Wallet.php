<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table='wallet';

    protected $fillable=['refid','type','amount','description','iscomplete', 'order_id', 'order_id_response', 'payment_id', 'payment_id_response','user_id'];

    protected $hidden=['created_at', 'updated_at', 'deleted_at','iscomplete'];

    public static function balance($userid){
        $wallet=Wallet::where('user_id', $userid)->where('iscomplete', true)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['Credit']??0)-($balances['Debit']??0);
    }


}
