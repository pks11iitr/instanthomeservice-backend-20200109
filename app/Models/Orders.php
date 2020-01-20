<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //public $timestamps=false;
    protected $table='orders';

    protected $fillable=['user_id', 'address', 'auto_address', 'name', 'lat', 'lang', 'booking_date', 'booking_time', 'isbookingcomplete', 'order_id'];

    protected $hidden=['created_at', 'user_id', 'deleted_at', 'payment_mode'];

    public function details(){
      return $this->hasMany('App\Models\Order_items', 'order_id');
    }
    public function time(){
        return $this->belongsTo('App\Models\TimeSlot', 'booking_time');
    }

}
