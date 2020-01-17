<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table="reviews";

    protected $fillable=['user_id', 'order_id', 'review', 'ratings'];

    protected $hidden=['created_at', 'updated_at', 'deleted_at' ];

    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
