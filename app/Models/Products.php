<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public $timestamps=false;
    protected $table='products';
    protected $fillable=['name','company','price','image','size','isactive','rating','categoryid','description','in_the_box'];

    public function category(){
        return $this->belongsTo('App\Models\Category', 'categoryid');
    }
}
