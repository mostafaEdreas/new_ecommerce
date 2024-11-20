<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $table = 'discounts';

    protected $fillable = [
        'start_date',
        'end_date',
        'discount',
        'type',
        'product_id',
    ];


    public function product(){
        return $this->belongsTo(product::class);
    }

    public function getIsAvailableAttribute(){
        return $this->start_date >= date('Y-m-d') &&  $this->end_date <= date('Y-m-d') ;
    }


    public function getProductNameAttribute(){
        return $this->product?->name;
    }

    public function getProductIdAttribute(){
        return $this->product?->id;
    }


    public function getProductPriceAttribute(){
        return $this->product?->price;
    }

    public function getAmountAttribute(){
        return $this->type? $this->discount * $this->product_price / 100 : $this->discount;
    }

    public function getPercentageAttribute(){
        return $this->type? $this->discount / $this->product_price * 100 : $this->discount;
    }

    public function getDiscountTypeAttribute(){
        return $this->type? 'Percentage'  : 'Amount';
    }
}
