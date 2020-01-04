<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $table='gallery';

    public function getDocPathAttribute($value){
        return Storage::url($value);
    }
}
