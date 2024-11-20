<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    protected $table = 'product_discounts';
    // public $timestamps = false;

    public function product(){
        return $this->belongsTo(product::class);
    }
}
