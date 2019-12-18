<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Model;

class Partners extends Model
{
    use Active;
    //public $timestamps=false;
    protected $table='partners';
    protected $fillable=['name','image','isactive'];

    protected $hidden =['created_at','updated_at','deleted_at', 'isactive'];
}
