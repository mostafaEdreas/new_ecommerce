<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestCartProductOption extends Model
{
    //
    protected $table='guest_cart_product_options';
    public $timestamps = false;
    
    public function option(){
        return $this->belongsTo('App\Models\ProductOption','option_id');
    }
}
