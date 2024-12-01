<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_stock_id',
        'quantity',
    ];

    public function productStock(){
        return $this->belongsTo(ProductStock::class);
    }

    public function getProductDiscountAmountAttribute(){
        return $this->productStock?->product_discount_amount ?? 0 ;
    }
    public function getProductpriceAttribute(){
        return $this->productStock?->price ?? 0;
    }

    public function getNetProductpriceAttribute(){
        return $this->productStock?->net_price ?? 0;
    }
}
