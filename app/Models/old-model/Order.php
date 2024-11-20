<?php

namespace App\Models;
use App\Models\OrderProduct;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';
    protected $fillable = ['status','address_id','user_id','payment_id','shipping_id','shipping_method_fees','payment_method_fees','products_price','coupoun_discount','coupon_id','payment_status','note','admin_seen','delivery_date','delivery_date'];


    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function address(){
        return $this->belongsTo('App\Models\Address','address_id');
    }

    public function shippingMethod(){
        return $this->belongsTo('App\Models\ShippingMethod','shipping_id');
    }

    public function paymentMethod(){
        return $this->belongsTo('App\Models\PaymentMethod','payment_id');
    }


    public function products(){
        return $this->hasMany(OrderProduct::class);
    }

    public static function orderCount(){
	    return Order::where('admin_seen',0)->count();
	}
    public function orderStatus(){
        $status =OrderStatus::where('order_id',$this->id)->pluck('status')->toArray();
        $orderStatus = OrderStatus::where('order_id',$this->id)->get();
        return [$status,$orderStatus];
    }
    public function delivery(){
        return $this->belongsTo(Delivery::class);
    }

    function scopeCheckBeforDelete($query) {
        return $query->whereHas('products') ;
    }
}
