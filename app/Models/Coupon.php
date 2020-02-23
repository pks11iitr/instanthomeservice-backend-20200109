<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table='coupons';

    protected $fillable=['code','title','amount','type','max_usage','current_usage','validity'];

    public function isValid(){
        if(!($this->max_usage<=0 || $this->max_usage>$this->current_usage)){
            return false;
        }
        //echo $this->validity.' a'.date('Y-m-d');
        if(!(empty($this->validity) || $this->validity>=date('Y-m-d'))){
            return false;
        }

        return true;
    }

    public function calculateDiscount($amount){
        if($this->type=='percent')
            return (int)($this->amount*$amount/100);
        else
            return $this->amount;
    }

    public function incrementUsage(){
        $this->current_usage=$this->current_usage+1;
        $this->save();
    }

}
