<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    public $timestamps=false;
    protected $table='order_items';

    public function product(){
        return $this->belongsTo('App\Products', 'product_id');
    }

}
