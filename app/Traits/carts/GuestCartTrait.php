<?php
namespace App\Traits\products;

use App\Models\Coupon;
use App\Models\GuestCart;
use Illuminate\Support\Str;


trait GuestCartTrait {

    private function getGuestCart($coupon_code = null){
        $session = $this->getOrCreateGuestCartSession();
        $coupon_id = $this->checkCouponCode($coupon_code);
        return  GuestCart::with(['items' ,'coupon']) ->firstOrCreate(['session_id' =>  $session ] , ['coupon_id' => $coupon_id ,'session_id' =>  $session] );
    }

    private function getOrGenerateGuestCartSession(){
        return session('cart_session',fn() => $this->generateUniqueName()) ;
    }

    private function generateUniqueName(){
        return 'guest' . '-' . Str::uuid();
    }

    private function checkCouponCode($coupon_code){
        if($coupon = Coupon::where($coupon_code)->first() ){
            return $coupon->id;
        };
        flasher()->addError( __('home.Sorry Coupon Not Found') ); // Add error to Flasher
        return null ;
    }
}