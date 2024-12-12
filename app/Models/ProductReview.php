<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{

    protected $table='product_reviews';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function product(){
       return  $this->belongsTo(Product::class);
    }

    public function getPercentageRateAttribute(){
        return ( $this->rate / 5) * 100;
    }


    public function getUserNameAttribute(){
        return $this->user?->name ;
    }


    public function getUserImageAttribute(){
        return $this->user?->image_source ;
    }



}
