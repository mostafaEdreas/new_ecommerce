<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview2 extends Model
{

    protected $table='product_reviews';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function product(){
       return  $this->belongsTo(Product::class);
    }

    public function getRateAttribute($rate){
        $percentage =( $rate / 5) * 100;
        return (object) ['rate'=> round($rate, 1),'percentage' =>round($percentage, 1)  ];
    }
}
