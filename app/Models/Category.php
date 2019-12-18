<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //public $timestamps=false;
    use Active;

    protected $table='category';

    protected $fillable=['title','image', 'description', 'parent','istop','isactive'];

    protected $hidden =['created_at','updated_at','deleted_at','parent','istop','isactive'];



    public function product(){
        return $this->hasMany('App\Models\Products', 'categoryid');
    }


    public function parentcategory(){
        return $this->belongsTo('App\Models\Category', 'parent');
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category', 'parent');
    }

}
