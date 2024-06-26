<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    //public $timestamps=false;
    use Active;

    protected $table='category';

    protected $fillable=['title','image', 'description', 'parent','istop','rate_url','isactive'];

    protected $hidden =['created_at','updated_at','deleted_at','parent','istop','isactive'];



    public function product(){
        return $this->hasMany('App\Models\Products', 'categoryid');
    }


    public function parentcategory(){
        return $this->belongsTo('App\Models\Category', 'parent');
    }

    public function rootcategory(){
        return $this->parentcategory()->with('rootcategory');
    }

    public function subcategories(){
        return $this->hasMany('App\Models\Category', 'parent');
    }

    public function getImageAttribute($value){
        return Storage::url($value);
    }

    public function getRateUrlAttribute($value){
        if(!empty($value))
            return Storage::url($value);
        return null;
    }



}
