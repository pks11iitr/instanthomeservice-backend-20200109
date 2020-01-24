<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Kodeine\Acl\Traits\HasRole;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'mobile','status','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function cart(){
        return $this->hasMany('App\Models\Cart', 'userid');
    }

    public function services(){
        return $this->belongsToMany('App\Models\Category', 'user_services', 'user_id', 'service_id');
    }

    public function times(){
        return $this->belongsToMany('App\Models\TimeSlot', 'user_times', 'user_id', 'time_id');
    }

    public function getImageAttribute($value){
        if($value){
            return Storage::url($value);
        }
        return '';
    }

    public function getNameAttribute($value){
        if($value){
            return $value;
        }
        return '';
    }

    public function getEmailAttribute($value){
        if($value){
            return $value;
        }
        return '';
    }

}
