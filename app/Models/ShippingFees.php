<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFees extends Model
{
    use HasFactory;

    protected $table = 'shipping_fees' ;
    protected $fillable = ['area_id','fees'];
}
