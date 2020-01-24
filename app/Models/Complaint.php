<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $table='complaints';
    protected $fillable=['user_id', 'order_id', 'attachment', 'description', 'is_resolved'];

    protected $hidden=['created_at', 'updated_at', 'deleted_at' ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
