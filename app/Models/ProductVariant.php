<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use DB;


class ProductVariant extends Model
{
	protected $table='product_variants';

    protected $fillable = [
        'product_stock_id',
        'product_attribute_value_id',
    ];








}
