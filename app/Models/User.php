<?php

namespace App\Models;

use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements JWTSubject
{
   use Notifiable;

   protected $hiden = ['password'];
   public $timestamps = false;

   protected $fillable = [
      'name',
      'email',
      'password'
   ];

   public function getJWTIdentifier() {
        return $this->getKey();
   }

   public function getJWTCustomClaims() {
    return [];
   }
}
