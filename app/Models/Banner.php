<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;
class Banner extends Model
{
  protected $table='banners';

    protected $fillable=['doc_path','isactive'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function getDocPathAttribute($value){
      return Storage::url($value);
    }
}
