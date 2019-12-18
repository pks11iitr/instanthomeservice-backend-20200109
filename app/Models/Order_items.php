<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_items extends Model
{
    //public $timestamps=false;
    protected $table='order_items';

    protected $fillable=['product_id', 'quantity', 'price', 'order_id', 'order_status'];

    protected $hidden=['created_at', 'order_id','updated_at', 'deleted_at', 'payment_mode'];

    public function product(){
        return $this->belongsTo('App\Models\Products', 'product_id');
    }


}
