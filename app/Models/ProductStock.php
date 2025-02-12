<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class ProductStock extends Model
{
    use HasFactory;
    protected $table = 'product_stock';
    protected $fillable = [
        'product_id',
        'stock',
        'price',
    ];

    public function delete()
    {
        $errors = [] ;
        // Check if the category has related products
        if (isEmpty($this->orders)) {
            $errors[] =  'Cannot delete a stock that has related orders.';
        }


        if(count( $errors)){
         return $errors;
        }

        return parent::delete();
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function values(){
        return $this->hasMany(ProductVariant::class , '');
    }


    public function valueInSameProduct($value_id , int $product_id){
        $stocks = Self::whereHas('values',function($q) use($value_id){
            $this->where('product_attribute_value_id' , $value_id);
        })->where('product_id' , $product_id)->get();
    }


    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function getProductNameAttribute(): string{
        return $this->product?->name;
    }


    public function getProductLinkAttribute(): string{
        return $this->product?->link;
    }

    public function getProductMainImageAttribute(): string{
        return $this->product?->main_image_source;
    }

    public function getProductDiscountAmountAttribute(): float{

        if($this->product?->discount){
            if(!$this->product?->discount_type){
                return $this->product?->discount_value;
            }
            return $this->product?->discount_value * $this->price / 100;

        }

        return 0 ;
    }

    public function getProductDiscountPercentageAttribute(): float{
        if($this->product?->discount){
            if($this->product?->discount_type){
                return $this->product?->discount_value;
            }
            return $this->product?->discount_value / $this->price * 100;
        }

        return 0 ;

    }


    public function getNetPriceAttribute(){
        return $this->price - $this->product_discount_amount ;
    }

    public function getCanEditOrDeleteAttribute(){
        return OrderProduct::where('product_stock_id', $this->id)->count() === 0;
   }
}
