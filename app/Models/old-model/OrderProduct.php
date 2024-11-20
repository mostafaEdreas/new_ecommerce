<?php

namespace App\Models;
use App\Models\OrderProductOption;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    protected $table = 'order_products';
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

    public function group(){
        return $this->belongsTo(Stock::class,'group_id');
    }
    public function color(){
        return $this->belongsTo('App\Models\Color','color_id');
    }

    public function optionPrice(){
        $price= OrderProductOption::where('order_id',$this->order_id)->where('order_product_id',$this->id)->sum('price');
        return $price;
    }

    public function options(){
        $options=OrderProductOption::where('order_product_id',$this->id)->get();
        return $options;
    }

    public function values(){
        $valueIds = OrderProductAttributeValue::where('order_product_id',$this->id)->pluck('attribute_value_id')->toArray();
        return AttributeValue::where('id',$valueIds)->first();
    }
    // public function productAttributeValues(){
    //     $attribute_value = CartProductAttributeValue::where('cart_product_id',$this->product_id)->where('cart_id',$this->cart_id)->first()->attribute_value_id;
    //     return AttributeValue::find($attribute_value);
    // }
}
