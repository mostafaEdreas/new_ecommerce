<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsed extends Model
{
    protected $table = 'coupon_useds';
    public $timestamps = false;
    public $fillable = ['user_id','coupon_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function coupon(){
        return $this->belongsTo(Coupon::class);
    }
    public function getUserNameAttribute(){
        return $this->user?->name ;
    }

    public function getUserphoneAttribute(){
        return $this->user?->phone ;
    }

    public function getCouponNameAttribute(){
        return $this->coupon?->name ;
    }

    public function getCouponCodeAttribute(){
        return $this->coupon?->code ;
    }

    public function getCouponAmountAttribute(){
        return $this->coupon?->amount ;
    }

    public function getCouponPercentageAttribute(){
        return $this->coupon?->percentage ;
    }

    public function getCouponTypeAttribute(){
        return $this->coupon?->type ;
    }





}
