<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    //
    protected $table = 'payment_methods';

    public function orders(){
        return $this->hasMany('App\Models\Order');
    }
    function scopeCheckBeforDelete($query) {
        return $query->whereHas('orders') ;
    }
}
