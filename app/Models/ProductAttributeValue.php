<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductAttributeValue extends Model
{
    protected $table = 'product_attributes';
    private $lang = LaravelLocalization::getCurrentLocale();

    protected $fillable = [
        'product_attribute_id',
        'value_id',
    ];

    public function attribute(){
        return $this->belongsTo(ProductAttribute::class) ;
    }


    public function value(){
        return $this->belongsTo(AttributeValue::class) ;
    }


    public function getValueNameAttribute(){
        return $this->value?->name ;
    }

    public function getValueIdAttribute(){
        return $this->value?->id ;
    }

}
