<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps=false;
    protected $table='category';

    protected $fillable=['title','image', 'description', 'parent','istop','isactive'];

    public function parent(){
        return $this->belongsTo('App\Models\Category', 'parent');
    }

    public function subcategories(){
            return $this->hasMany('App\Models\Category', 'parent');
    }

}
