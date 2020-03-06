<?php

namespace App\Models;

use App\Models\Traits\DocumentUploadTrait;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use DocumentUploadTrait;
    //public $timestamps=false;
    protected $table='orders';

    protected $fillable=['user_id', 'address', 'auto_address', 'name', 'lat', 'lang', 'booking_date', 'booking_time','isbookingcomplete', 'order_id','total_after_inspection','status'];

    protected $hidden=['created_at', 'user_id', 'deleted_at', 'payment_mode'];

    public function details(){
      return $this->hasMany('App\Models\Order_items', 'order_id');
    }
    public function time(){
        return $this->belongsTo('App\Models\TimeSlot', 'booking_time');
    }

    public function vendors(){
        return $this->belongsToMany('App\User', 'vendor_orders', 'order_id', 'vendor_id')->withPivot('status');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function reviews(){
        return $this->hasOne('App\Models\Review', 'order_id');
    }

    public function applyCoupon($coupon){
        if(empty($coupon)){
            $this->removeCoupon();
            return true;
        }

        $coupon=Coupon::where('code', $coupon)->first();
        if(empty($coupon) || (!empty($coupon) && !$coupon->isValid()))
            return false;

        //remove previous coupon if any
        if(!empty($this->coupon))
            $this->removeCoupon();

        //apply new coupon
        $this->instant_discount=$coupon->calculateDiscount($this->total_after_inspection);
        $this->total_after_inspection=$this->total_after_inspection-$this->instant_discount;
        $this->coupon=$coupon->code;
        $this->save();

        $coupon->incrementUsage();
        return true;
    }

    public function removeCoupon(){
        $this->total_after_inspection=$this->total_after_inspection+$this->instant_discount;
        $this->coupon=null;
        $this->instant_discount=0;
        $this->save();
    }

}
