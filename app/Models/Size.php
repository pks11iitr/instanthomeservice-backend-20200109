<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table='product_prices';

    protected $hidden =['created_at','updated_at','deleted_at'];
}
