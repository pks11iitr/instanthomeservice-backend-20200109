<?php

namespace App\Models;

use App\Models\Traits\DocumentUploadTrait;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use DocumentUploadTrait;
    //public $timestamps=false;
    protected $table='orders';

    protected $fillable=['user_id', 'address', 'auto_address', 'name', 'lat', 'lang', 'booking_date', 'booking_time','isbookingcomplete', 'order_id','total_after_inspection'];

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

}
