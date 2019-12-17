<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //public $timestamps=false;
    protected $table='orders';

    protected $fillable=['user_id'];

    public function details(){
      return $this->hasMany('App\Models\Order_items', 'order_id');
    }

}
