<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','country_code','mobile','discount_code','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     * protected $casts = [
    *  'email_verified_at' => 'datetime',
    * ];
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
   
    public function roles(){
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id' );
    }

    public function hasAnyRoles($roles){
        if ($this->roles()->whereIn('name', $roles)->first()) {
            return true;
        }
        return false;
    }

    public function hasRole($role){
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
/*
    public function getStatusAttribute($val){
        return $val == 0 ? 'Active' : 'inactive';
    }
*/
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
}
