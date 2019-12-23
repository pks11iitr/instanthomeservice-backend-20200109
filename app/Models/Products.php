<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Products extends Model
{
    //public $timestamps=false;
    use Active;

    protected $table='products';
    protected $fillable=['name','company','price','image','size','isactive','rating','categoryid','description','in_the_box', 'cut_price'];

    protected $hidden=['created_at', 'isactive','updated_at', 'deleted_at', 'payment_mode', 'categoryid', 'subcategoryid', 'specialcategoryid', ];

    public function category(){
        return $this->belongsTo('App\Models\Category', 'categoryid');
    }

    public function getImageAttribute($value){
        return Storage::url($value);
    }

    public function sizeprice(){
        return $this->belongsTo('App\Models\Size', 'product_id');
    }
}
