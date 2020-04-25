<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerQuery extends Model
{
    protected $table='customer_queries';

    protected $guarded=['id','created_at', 'deleted_at', 'updated_at'];

}
