<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;
	protected $table='product_variants';

    protected $fillable = [
        'product_stock_id',
        'product_attribute_value_id',
    ];


    public function stock(){
        return $this->belongsTo(ProductStock::class);
    }


    public function value(){
        return $this->belongsTo(ProductAttributeValue::class , 'product_attribute_value_id') ;
    }












}
