<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

class Coupon extends Model
{
    protected $table = 'coupons';

    public function scopeIsValid($query)
    {
        return $query->where('expire_date','<',date('Y-m-d'));
    }

    public function couponUsed()
    {
        return $this->hasMany(CouponUsed::class);
    }

    public function isAuthUsed(){
        return $this->couponUsed()->where('user_id',auth()->user()->id)->exists();
     }

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    function scopeCheckBeforDelete($query) {
        return $query->whereHas('orders') ;
    }

}
