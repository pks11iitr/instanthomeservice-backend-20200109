<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    //public $timestamps=false;
    protected $table='partners';
    protected $fillable=['name','image','isactive'];
}
