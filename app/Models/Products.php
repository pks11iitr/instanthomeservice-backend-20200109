<?php

namespace App\Models;

use App\Models\Traits\Active;
use App\Models\Traits\DocumentUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Products extends Model
{
    use Active, DocumentUploadTrait;

    protected $table='products';
    protected $fillable=['name','price','image', 'isactive', 'categoryid'];

    protected $hidden=['created_at', 'isactive','updated_at', 'deleted_at' ];

    public function category(){
        return $this->belongsTo('App\Models\Category', 'categoryid');
    }

    public function getImageAttribute($value){
        return Storage::url($value);
    }

    public function sizeprice(){
        return $this->hasMany('App\Models\Size', 'product_id');
    }
}
