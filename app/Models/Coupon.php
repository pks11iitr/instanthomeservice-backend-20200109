<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table='coupons';

    protected $fillable=['code','title','amount','type','max_usage','validity'];
}
