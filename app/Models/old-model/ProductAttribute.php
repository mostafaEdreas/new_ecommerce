<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductAttribute extends Model
{
    protected $table = 'product_attributes';
    protected $fillable = ['price'];
    protected $appends = ['attrbute'];
    public function value(){
        return $this->belongsTo(ProductAttributeValue::class);
    }

    public function getNameAttribute(){
        $lang = LaravelLocalization::getCurrentLocale();
        return $this->value ?  $this->value?->{'name_'.$lang}: null ;
    }
}
