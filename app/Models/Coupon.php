<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon ;

use function PHPUnit\Framework\isEmpty;

class Coupon extends Model
{
    protected $table = 'coupons';

    private $lang ;

    // order is important for this array
    private $checks = [
        ['function' => 'isStart', 'fail_message' => __('home.This coupon is not valid yet.'), 'parameter' => []],
        ['function' => 'isEfficient', 'fail_message' => __('home.This coupon has expired.'), 'parameter' => []],
        ['function' => 'isUsed', 'fail_message' => __('home.You have already used this coupon.'), 'parameter' => []],
        ['function' => 'isMaxUsed', 'fail_message' => __('home.This coupon has reached its maximum usage limit.'), 'parameter' => []],
        ['function' => 'checkMinPrice', 'fail_message' => __('home.The total price does not meet the minimum required.'), 'parameter' => ['total_price']], // Example with $total_price
    ];



    protected $fillable = [
        'name_ar',
        'name_en',        
        'code',          
        'start_date',    
        'end_date',      
        'max_use',        
        'min_price',      
        'discount',      
        'discount_type',  
        'type',           
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
        'discount' => 'float'
    ];

    public function getNameAttribute(){
        return $this->{'name_'.$this->lang};
    }

    public function users()
    {
        return $this->hasMany(CouponUsed::class) ;
    }

    public function getIsMaxUsedAttribute()
    {
        return $this->users->count() >= $this->max_use ;
    }
    public function getIsEfficientAttribute()
    {
        return $this->end_data->startOfDay() <= now()->startOfDay();
    }


    public function getIsStartAttribute()
    {
        return  $this->start_date->startOfDay() >=now()->startOfDay();
    }

    public function getIsUsedAttribuite()
    {
        return $this->users->where('user_id',auth()->user()->id)->count() > 0 ;
    }

    public function checkMinPrice($total_price = 0): bool
    {
        return  $this->min_price <= $total_price;
    }

    public function canUse($total_price = 0)
    {
        $can_use = true;

        foreach ($this->checks as $check) {
            $function = $check['function'];
            $parameters = $check['parameter'];


            foreach ($parameters as &$parameter) {
                if ($parameter === 'total_price') {
                    $parameter = $total_price;
                }
            }

            $result = call_user_func_array([$this, $function], $parameters);

            if (!$result) {
                $can_use = false;
                flasher()->addError( $check['fail_message'] ); // Add error to Flasher
            }
        }

        return $can_use ;
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
