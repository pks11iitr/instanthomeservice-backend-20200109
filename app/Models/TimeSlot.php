<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use Active;
    protected $table ='timeslots';

    protected $hidden =['created_at','updated_at','deleted_at'];
}
