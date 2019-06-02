<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class JwtUser extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $fillable = ['name', 'email'];
    protected $hidden = ['password','remember_token','token'];

    public function getJWTIdentifier()
    {
    	return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
    	return [];
    }

}
