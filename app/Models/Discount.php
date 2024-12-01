<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{

    use HasFactory;
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


    public function getDiscountTypeAttribute(){
        return $this->type? 'Percentage'  : 'Amount';
    }

}
