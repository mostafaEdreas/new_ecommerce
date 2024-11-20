<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductAttribute extends Model
{


    protected $table = 'product_attributes';

    protected $fillable = [
        'product_id',
        'attribute_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }

    public function getAttributeNameAttribute(){
        return $this->attribute?->name;
    }

    public function getAttributeIdAttribute(){
        return $this->attribute?->id;
    }
    public function value(){
        return $this->hasMany(ProductAttributeValue::class);
    }
}
