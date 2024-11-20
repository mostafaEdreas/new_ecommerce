<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    //
    protected $table = 'shipping_methods';

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }

    function scopeCheckBeforDelete($query) {
        return $query->whereHas('orders') ;
    }
}
