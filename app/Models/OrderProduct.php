<?php

namespace App\Models;
use App\Models\OrderProductOption;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    //
    protected $table = 'order_products';
    protected $fillable = ['product_stock_id','price','dicount_id','quantity','total','product_discount'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($orderProduct) {
            $stock = ProductStock::find($orderProduct->product_stock_id);
            $orderProduct->price = $stock->price ;
            
        });
    }


    public function product(){
        return $this->belongsTo(ProductStock::class);
    }
    public function order(){
        return $this->belongsTo('App\Models\Order');
    }

}
