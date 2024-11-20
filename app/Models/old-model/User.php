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
        'f_name','l_name','country_id', 'email', 'password',
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
    public function userAreas(){
        return Area::where('region_id',$this->region_id)->get();

    }
    public function userRegions(){
        return Region::where('country_id',$this->country_id)->get();
    }
    public function cartProducts(){
        return $this->hasMany(CartProduct::class);
    }
    public function country(){
        return $this->belongsTo('App\Models\Country','country_id');
    }

    public function region(){
        return $this->belongsTo('App\Models\Region','region_id');
    }

    public function area(){
        return $this->belongsTo('App\Models\Area','area_id');
    }

    public function isAdmin(){
        return $this->is_admin;
    }

    public function name(){
        return $this->f_name.' '.$this->l_name;
    }
    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
    public function isTookProduct(int $product_id){
        $product_exists  = $this->orders()->whereHas('products',function($order_products_query)use($product_id){
            $order_products_query->whereHas('group',function($group_query)use($product_id){
                $group_query->where('product_id',$product_id);
            });
        })->exists();
        return $product_exists ;

    }
    public function adresses(){
        return $this->hasMany('App\Models\Address');
    }
    public function wishlist(){
        return $this->hasMany('App\Models\Wishlist');
    }
    public function shippingAdress(){
        return Address::where('user_id',auth()->user()->id)->where('is_primary',1)->first();
    }

    function scopeCheckBeforDelete($query){
        return $query->whereHas('adresses')
        ->orWhereHas('orders') ;
    }



}
