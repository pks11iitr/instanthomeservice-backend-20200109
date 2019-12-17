<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    //public $timestamps=false;
    protected $table='order_items';

    protected $fillable=['product_id', 'quantity', 'price', 'order_id'];

    public function product(){
        return $this->belongsTo('App\Models\Products', 'product_id');
    }


}
