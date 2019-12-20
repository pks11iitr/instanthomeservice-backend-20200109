<?php

namespace App\Models;

use App\Models\Traits\Active;
use Illuminate\Database\Eloquent\Model;
use Storage;
class Banner extends Model
{
    use Active;
  protected $table='banners';

    protected $fillable=['doc_path','isactive'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function getDocPathAttribute($value){
      return Storage::url($value);
    }
}
