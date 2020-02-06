<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Complaint extends Model
{
    protected $table='complaints';
    protected $fillable=['user_id', 'order_id', 'attachment', 'description', 'is_resolved','refid'];

    protected $hidden=['created_at', 'updated_at', 'deleted_at' ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getAttachmentAttribute($value){
        if($value)
            return Storage::url($value);
        return '';
    }

}
