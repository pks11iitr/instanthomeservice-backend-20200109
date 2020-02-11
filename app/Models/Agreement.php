<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Agreement extends Model
{
    protected $table='agreement';

    protected $fillable=['doc_path'];

    public function getDocPathAttribute($value){
        return Storage::url($value);
    }
}
