<?php
namespace App\Traits\products;

use App\Models\Cart;
use App\Models\Coupon;
use Illuminate\Support\Str;


trait CartTrait {

    private function getCart($coupon_code = null){

        $coupon_id = $this->checkCouponCode($coupon_code);
        $user_id = auth()->user()->id ;
        return  Cart::with(['items' ,'coupon']) ->firstOrCreate(['user_id' =>   $user_id ] , ['coupon_id' => $coupon_id ,'user_id' =>  $user_id] );
    }



    private function checkCouponCode($coupon_code){
        if($coupon = Coupon::where($coupon_code)->first() ){
            return $coupon->id;
        };
        flasher()->addError( __('home.Sorry Coupon Not Found') ); // Add error to Flasher
        return null ;
    }
}