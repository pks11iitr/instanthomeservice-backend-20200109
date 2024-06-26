<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table="reviews";

    protected $fillable=['user_id', 'order_id', 'review', 'ratings', 'category_id'];

    protected $hidden=['updated_at', 'deleted_at' ];

    public function user(){
        return $this->belongsTo('App\User', 'user_id');
    }

    public function order(){
        return $this->belongsTo('App\Models\Orders',  'order_id');
    }

}
