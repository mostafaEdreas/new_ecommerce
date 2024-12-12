<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasRoles;
    use Notifiable;

    protected $table='users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name',
        'l_name',
        'phone',
        'email',
        'image',
        'them',
        'email_verified_at',
        'password',
        'is_admin',
        'admin_seen',

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function couponUseds(){
        return $this->hasMany(CouponUsed::class) ;
    }


    public function address(){
        return $this->hasMany(Address::class) ;
    }

    public function getPrimaryAddressAttribute(){
        return $this->addresses()->where('is_primary', 1)->first() ?? $this->addresses()->first() ;
    }


    public function isAdmin(){
        return $this->is_admin;
    }

    public function GetnameAttribute(){
        return $this->f_name.' '.$this->l_name;
    }

    public function name(){
        return $this->f_name.' '.$this->l_name;
    }





}
