<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon ;

class Coupon extends Model
{
    protected $table = 'coupons';

    private $lang ;
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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the current locale dynamically
        $this->lang = Helper::getLang();

    }

    public function delete()
    {
        $errors = [] ;
        if ($this->users()->exists()) {
            $errors[] = 'The used coupon cannot be deleted.';
        }

        if(count( $errors)){
            return $errors;
           }

           return parent::delete();
    }

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


    public function getDiscountTypeTextAttribute()
    {
        return $this->discount_type ?  __('home.percentage') :__('home.amount') ;
    }


    public function getStartDateAttribute($value)
    {
        return  Carbon::parse($value) ->format('Y-m-d') ;
    }

    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value) ->format('Y-m-d') ;
    }







}
