<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestCart extends Model
{
    protected $table = 'guest_carts';

    protected $fillable = ['session_id' ,'coupon_id'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function items()
    {
        return $this->hasMany(GuestCartItems::class);
    }

    public function getCouponNameAttribute()
    {
        return $this->coupon?->name;
    }

    public function getCouponStartDateAttribute()
    {
        return $this->coupon?->start_date;
    }

    public function getCouponEndDateAttribute()
    {
        return $this->coupon?->end_date;
    }

    public function getCouponTypeAttribute()
    {
        return $this->coupon?->type;
    }

    // Total price of items in the cart
    public function getTotalPriceAttribute()
    {
        return $this->items()->sum('total');
    }

    // Calculate coupon amount based on the type of discount
    public function getCouponAmountAttribute()
    {
        if ($this->coupon) {
            if ($this->coupon->discount_type) {
                // Percentage discount
                return ($this->coupon->discount * $this->total_price) / 100;
            }
            // Fixed discount value
            return $this->coupon->discount;
        }
        return 0;
    }

    // Calculate coupon percentage (if discount type is percentage)
    public function getCouponPercentageAttribute()
    {
        if ($this->coupon) {
            if ($this->coupon->discount_type) {
                return $this->coupon->discount;
            }
            return ($this->coupon->discount / $this->total_price) * 100;
        }
        return 0;
    }

    // Net total price after applying coupon (if applicable)
    public function getNetTotalPriceAttribute()
    {
        return $this->can_use_coupon ? $this->total_price - $this->coupon_amount : $this->total_price;
    }

    // Check if the coupon can be used
    public function getCanUseCouponAttribute()
    {
        if ($this->coupon) {
            return $this->coupon->canUse($this->total_price);
        }
        return false;  // Return false if no coupon exists
    }
}
