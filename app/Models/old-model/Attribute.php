<?php

namespace App\Models;

use App\Models\ProductAttribute;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;
use DB;


class Attribute extends Model
{
    //
	protected $table = 'attributes';

    public function values(){
        return $this->hasMany(AttributeValue::class);
    }

    public function productAttributeValues($id){
       return  $this->hasMany(ProductAttribute::class)->where('product_id',$id)->with('attributeValue')->get();
    }

    public function productAttribute(){
        return  $this->hasMany(ProductAttribute::class,'attribute_id');
     }

     function scopeCheckBeforDelete($query){
        return $query->whereHas('values')
        ->orWhereHas('productAttribute');
    }

}



