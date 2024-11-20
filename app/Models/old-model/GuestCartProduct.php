<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Database\Eloquent\Builder;

class GuestCartProduct extends Model
{
    //
    protected $table='guest_cart_products';
    protected $fillable = ['group_id','session_id','quantity','guest_cart_id'];

    protected $appends = ['sub_total_product','total_product'];
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
        $price= GuestCartProductOption::where('guest_cart_id',$this->guest_cart_id)->where('guest_cart_product_id',$this->id)->sum('price');
        return $price;
    }

    public function options(){
        $options=GuestCartProductOption::where('guest_cart_product_id',$this->id)->get();
        return $options;
    }
    public function productAttributeValues(){
        $attribute_value = GuestCartProductAttribute::where('guest_cart_product_id',$this->product_id)->where('guest_cart_id',$this->guest_cart_id )->first()->attribute_value_id;
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
