<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;
use Carbon\Carbon ;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Coupon extends Model
{
    protected $table = 'coupons';

    private $lang = LaravelLocalization::getCurrentLocale();

    protected $fillable = [
        'name_ar',         // Arabic name of the discount
        'name_en',         // English name of the discount
        'code',            // Discount code
        'start_date',      // Start date of the discount
        'end_date',        // End date of the discount
        'max_use',         // Maximum number of users who can use the discount
        'min_price',       // Minimum invoice total for discount to apply
        'discount',        // Amount of the discount
        'discount_type',   // Type of discount (e.g., value or percentage)
        'type',            // Type of discount (e.g., general or specific)
    ];

    protected $casts = [
        'start_date' => 'date:Y-m-d',
        'end_date' => 'date:Y-m-d',
    ];

    public function getNameAttribute(){
        return $this->{'name_'.$this->lang};
    }

    public function users()
    {
        return $this->hasMany(CouponUsed::class) ;
    }

    public function isMaxUsed()
    {
        return $this->users->count() >= $this->max_use ;
    }
    public function IsValid()
    {
        return $this->end_data < date('Y-m-d') && $this->start_date > date('Y-m-d') ;
    }

    public function IsUsed()
    {
        return $this->users->where('user_id',auth()->user()->id)->count() > 0 ;
    }

    public function checkPrice ()
    {
        return  0 ; // handle after create product model
    }


    public function getAmountAttribute()
    {
        if(!$this->discount_type){
            return $this->discount ;
        }
        return  0  ; // hhandle after create product model
    }


    public function getPercentaAttribute()
    {
        if(!$this->discount_type){
            return 0 ; // handle after create product model
        }
        return  $this->discount  ;
    }


    public function getTypeAttribute()
    {
        return $this->discount_type ?  __('home.percentage') :__('home.amount') ;
    }



}
