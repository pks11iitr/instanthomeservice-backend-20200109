<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //public $timestamps=false;
    protected $table='cart';

    protected $fillable=['quantity','product_id', 'userid', 'size_id'];

    protected $hidden =['created_at','updated_at','deleted_at'];

    public function product(){
        return $this->belongsTo('App\Models\Products', 'product_id');
    }

    public function size(){
        return $this->belongsTo('App\Model\Size', 'size');
    }

}
