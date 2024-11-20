<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stock';
    protected $fillable =['image_id','product_id','product_attribute_id','stock','price'];
    protected $casts =
    [
        'product_attribute_id'=>'array',
    ];

    protected $appends = ['price_details','image','images'];

    public function getProductGroupsAttribute(){
        $product_attribute_ids = $this->product_attribute_id ;
        return ProductAttribute::whereIn('id' ,$product_attribute_ids)->groupBy('attribute_id')->with('product','attribute','attributeValue')->get();
    }

    public function attributes(){
        $product_attribute_ids = $this->product_attribute_id ;
        $product_attribute = ProductAttribute::whereIn('id' ,$product_attribute_ids);
        $atrriute_ids =  $product_attribute->groupBy('attribute_id')  ->pluck('attribute_id')->toArray();
        $atrriute_value_ids = $product_attribute ->pluck('attribute_value_id')->toArray();
        return Attribute::whereIn('id',$atrriute_ids)->with(['values'=>function($query)use($atrriute_value_ids){
            $query->whereIn('id',$atrriute_value_ids);
        }])->get();
    }
    public function getAvilableValuesForGroupAttribute(){
        $product_attribute_ids = $this->product_attribute_id ;
        $except_attribute_ids = ProductAttribute::whereIn('id' ,$product_attribute_ids)->pluck('attribute_id');
        return ProductAttribute::whereNotIn('attribute_id' ,$except_attribute_ids)->where('product_id',$this->product_id)->get();
    }

    public function getCleanAttribute(){
        $products_attribute_ids_in_group = $this->product_attribute_id ;
        $products_attribute_ids_in_product_attripute = ProductAttribute::whereIn('id', $products_attribute_ids_in_group)->pluck('id')->toArray();
        $Isfind_product_attribute = array_intersect($products_attribute_ids_in_product_attripute, $products_attribute_ids_in_group);
        $this->image_id = ProductImage::find($this->image_id)?->id;
        $this->product_attribute_id = $Isfind_product_attribute;
        $this->save();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute(){
        return count($this->product?->images())> 0 ?$this->product?->images()[0]:(object)['image'=>null,'id'=>null,'product_id'=>null];
    }

    public function getImagesAttribute(){
        return $this->product?->images();
    }

    public function gruopsHasSamePrice($product_id){
        return Stock::where('price',$this->price)->whereNot('image_id',$this->image_id)->where('product_id',$product_id)->get();
    }



    public function getPriceDetailsAttribute(){

        $discount = $this->product?->discount ;
        $price = new stdClass();
        if(!($this->price > 0)){
            $price->discount_value =0 ;
            $price->percentage = 0 ;
            $price->old_price = 0  ;
            $price->new_price = 0 ;
            return $price ;
        }
        if ($discount) {
           if ($discount->value_type == 'percentage') {
                $price->discount_value = ($this->price * $discount->value) /100 ;
                $price->percentage = $discount->value ;
                $price->old_price = $this->price  ;
                $price->new_price = $this->price -  $price->discount_value ;

           }elseif($discount->value_type == 'value'){
                $price->discount_value = $discount->value ;
                $price->percentage = ($discount->value / $this->price ) * 100 ;
                $price->old_price = $this->price  ;
                $price->new_price = $this->price -  $price->discount_value ;
            }
        }else{
                $price->discount_value =0 ;
                $price->percentage = 0 ;
                $price->old_price = 0  ;
                $price->new_price = $this->price ;
        }

        return $price ;
    }

    public function cart(){
        $this->hasMany(Cart::class);
    }

    public function orders(){
        return $this->hasMany(OrderProduct::class);
    }


    function scopeCheckBeforDelete($query) {
        return $query->whereHas('orders') ;
    }
}
