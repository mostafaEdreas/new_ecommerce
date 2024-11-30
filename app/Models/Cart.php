<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    protected $table='carts';

    protected $fillable = ['user_id', 'coupon_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }

    public function items(){
        return $this->hasMany(CartItems::class);
    }

    public function getCouponNameAtrribute(){
        return $this->coupon?->name ;
    }

    public function getCouponStratDateAtrribute(){
        return $this->coupon?->end_data ;
    }
    public function getCouponEndDateAtrribute(){
        return $this->coupon?->start_data ;
    }

    public function getCouponTypeAtrribute(){
        return $this->coupon?->type ;
    }

    public function getTotalPriceAttribute ()
    {
        return  $this->items()->sum('total');
    }


    public function checkPrice ()
    {
        return  $this->total_price >= $this->coupon?->min_price ; 
    }


    public function getCouponAmountAttribute()
    {
        if(!$this->coupon?->discount_type){
            return $this->coupon?->discount ;
        }
        return  $this->coupon?->discount * $this->total_price / 100  ; // hhandle after create product model
    }


    public function getCouponPercentaAttribute()
    {
        if($this->coupon?->discount_type){
            return $this->coupon?->discount ;
        }
        return  $this->coupon?->discount / $this->total_price * 100  ; // hhandle after create product model
    }

    public function getNetTotalPriceAttribute ()
    {
        return  $this->total_price - $this->coupon_amount ;
    }




    

}