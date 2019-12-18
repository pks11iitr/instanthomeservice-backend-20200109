<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //public $timestamps=false;
    protected $table='products';
    protected $fillable=['name','company','price','image','size','isactive','rating','categoryid','description','in_the_box', 'cut_price'];

    protected $hidden=['created_at', 'isactive','updated_at', 'deleted_at', 'payment_mode', 'categoryid', 'subcategoryid', 'specialcategoryid', ];

    public function category(){
        return $this->belongsTo('App\Models\Category', 'categoryid');
    }
}
