<?php

namespace App\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;
    protected $hidden = [
        'created_at', 'updated_at'
    ];
    public function users(){
        return $this->belongsToMany('App\Models\User', 'role_user', 'role_id', 'user_id');
    }
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
