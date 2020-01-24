<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    protected $table='documents';

    public $fillable=['doc_path','uploaded_by','entity_type', 'entity_id'];

    public function getDocPathAttribute($value){
        return Storage::url($value);
    }
}
