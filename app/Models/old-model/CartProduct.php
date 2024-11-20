<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use DB;

class CartProduct extends Model
{
    //
    protected $table='cart_products';

    protected $fillable = ['group_id','user_id','quantity','cart_id'];
    public $timestamps = false;
    protected static function booted()
    {
        static::addGlobalScope('hasGroup', function (Builder $builder) {
            $builder->whereHas('group',function($q){
                $q->whereNotNull('price')->where('price','>',0)
                ->whereJsonLength('product_attribute_id', '>', 0)
                ->whereNotNull('product_attribute_id')->whereHas('product') ;          });
        });
    }
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id','id');
    }


    public function color(){
        return $this->belongsTo('App\Models\Color','color_id','id');
    }

    public function optionPrice(){
        $price= CartProductOption::where('cart_id',$this->cart_id)->where('cart_product_id',$this->id)->sum('price');
        return $price;
    }

    public function options(){
        $options=CartProductOption::where('cart_product_id',$this->id)->get();
        return $options;
    }
    public function totalPrice(){
        $price= CartProduct::where('cart_id',$this->cart_id)->sum('price');
        return $price;
    }
    public function productAttributeValues(){
        $attribute_value = CartProductAttributeValue::where('cart_product_id',$this->product_id)->where('cart_id',$this->cart_id)->first()->attribute_value_id;
        return AttributeValue::find($attribute_value);
    }

    public function group(){
        return $this->belongsTo(Stock::class,'group_id','id') ;
    }


    public function getSubTotalProductAttribute(){
        return $this->group->price_details->old_price * $this->quantity ;
    }

    public function getTotalProductAttribute(){
        return $this->group->price_details->new_price * $this->quantity ;
    }

}
