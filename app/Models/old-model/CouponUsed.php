<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsed extends Model
{
    protected $table = 'coupon_used';
    public $timestamps = false;
    public $fillable = ['user_id','coupon_id'];


}
