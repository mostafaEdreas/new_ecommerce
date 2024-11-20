<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Region;
use App\Models\Area;
use App\Models\Category;
use App\Models\Product;
use App\Models\OrderProduct;
use DB;
use App\Models\Vendor;
use App\Models\Brand;
use App\Models\CategoryAttribute;
use App\Models\Attribute;
use App\Models\Wishlist;
use Auth;
use App\Models\AttributeValue;
use App\Models\ProductAttribute;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductOption;
use App\Models\ProductPrice;
use App\Models\Address;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\CartProductOption;
use App\Models\CartProductAttributeValue;
use App\Models\ProductDiscount;
use App\Models\Coupon;
use App\Models\CouponProduct;
use App\Models\CouponCategory;
use App\Models\CouponBrand;
use App\Models\CouponUser;
use App\Models\CouponRegion;
use App\Models\CouponShipping;
use Carbon\Carbon;


class CheckCouponController extends Controller
{
    /////////// FUNCTION CHECK COUPON ////////////
    public function checkCoupon(){
        $couponCode=$_POST['couponCode'];
        $userCart=Cart::where('user_id',Auth::user()->id)->first();
        $totalCartPrice = $userCart->total_price;
        $checkCoupon=Coupon::where('code',$couponCode)->first();
        $cartCouponProductsCount=0;
        $discount = 0;

        if(! $checkCoupon || $userCart->coupon_id == $checkCoupon->id ){
            if(!$checkCoupon){
                $couponStatus= trans('home.Sorry Coupon Not Found');
            }elseif($userCart->coupon_id == $checkCoupon->id){
                $couponStatus= trans('home.This Coupon already in use');
            }
        }else{
            if(! $checkCoupon){
                $couponStatus=trans('home.Sorry Coupon Not Found !');
            }else{
                if($checkCoupon->expire_date < Carbon::now()->format('Y-m-d')){
                    $couponStatus=trans('home.Sorry this is Expired Coupon');
                }else{
                    $couponUsed= Cart::where('coupon_id',$checkCoupon->id)->count();
                    if($couponUsed  >= $checkCoupon->max_used){
                        $couponStatus=trans('home.Sorry Coupon has been reached to maximum use');
                    }else{
                        if($totalCartPrice <= $checkCoupon->order_min_price){
                            $couponStatus=trans('home.Sorry Coupon only valid for price above').' '. $checkCoupon->order_min_price.' '.trans('home.EGP');
                        }else{
                            /////// genereal coupon//////////
                            if($checkCoupon->coupon_type=='general'){
                                if($checkCoupon->value_type == 'value'){
                                    $discount= $checkCoupon->value ;
                                }else{
                                    $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                }

                                ///// apply coupon to cart///////
                                $userCart->coupon_id=$checkCoupon->id;
                                $userCart->coupon_discount=$discount;
                                $userCart->total_price=$userCart->products_price - $discount;
                                $userCart->save();

                                $couponStatus=trans('home.Coupon used Successfully !');

                                \Session::put('check_coupon',$couponStatus);

                                return response()->json([$couponStatus,$discount]);

                            }else{

                                if($checkCoupon->coupon_type=='product'){
                                    $couponProductIds=CouponProduct::where('coupon_id',$checkCoupon->id)->pluck('product_id')->toArray();
                                    $cartProductId=CartProduct::where('user_id',Auth::user()->id)->where('cart_id',$userCart->id)->pluck('product_id')->toArray();
                                    $cartCouponProductsCount=count(array_intersect($couponProductIds,$cartProductId));

                                    if($cartCouponProductsCount > 0){

                                        if($checkCoupon->value_type == 'value'){
                                            $discount= $checkCoupon->value ;
                                        }else{
                                            $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                        }

                                        ///// apply coupon to cart///////
                                        $userCart->coupon_id=$checkCoupon->id;
                                        $userCart->coupon_discount=$discount;
                                        $userCart->total_price=$userCart->products_price - $discount;
                                        $userCart->save();
                                        $couponStatus=trans('home.Coupon used Successfully !');

                                    }else{
                                        $couponStatus=trans('home.Sorry can not apply this Coupon');
                                    }
                                }

                                if($checkCoupon->coupon_type=='category'){
                                    $CouponCategoriesIds=CouponCategory::where('coupon_id',$checkCoupon->id)->pluck('category_id')->toArray();
                                    $productIds=ProductCategory::whereIn('category_id',$CouponCategoriesIds)->pluck('product_id')->toArray();
                                    $cartProductIds=CartProduct::where('user_id',Auth::user()->id)->where('cart_id',$userCart->id)->pluck('product_id')->toArray();
                                    $cartCouponProductsCount=count(array_intersect($CouponCategoriesIds,$cartProductIds));

                                    if($cartCouponProductsCount > 0){
                                        if($checkCoupon->value_type == 'value'){
                                            $discount= $checkCoupon->value ;
                                        }else{
                                            $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                        }

                                        ///// apply coupon to cart///////
                                        $userCart->coupon_id=$checkCoupon->id;
                                        $userCart->coupon_discount=$discount;
                                        $userCart->total_price=$userCart->products_price - $discount;
                                        $userCart->save();
                                        $couponStatus=trans('home.Coupon used Successfully !');

                                        $couponStatus="Coupon used Successfully !";

                                    }else{

                                        $couponStatus=trans('home.Sorry can not apply this Coupon');
                                    }
                                }

                                if($checkCoupon->coupon_type=='brand'){
                                    $CouponBrandIds=CouponBrand::where('coupon_id',$checkCoupon->id)->pluck('brand_id')->toArray();
                                    $couponBrandProductIds=Product::whereIn('brand_id',$CouponBrandIds)->pluck('id')->toArray();
                                    $cartProductIds=CartProduct::where('user_id',Auth::user()->id)->where('cart_id',$userCart->id)->pluck('product_id')->toArray();
                                    $cartCouponProductsCount=count(array_intersect($couponBrandProductIds,$cartProductIds));

                                    if($cartCouponProductsCount > 0 ){
                                        if($checkCoupon->value_type == 'value'){
                                            $discount= $checkCoupon->value ;
                                        }else{
                                            $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                        }

                                        ///// apply coupon to cart///////
                                        $userCart->coupon_id=$checkCoupon->id;
                                        $userCart->coupon_discount=$discount;
                                        $userCart->total_price=$userCart->products_price - $discount;
                                        $userCart->save();
                                        $couponStatus=trans('home.Coupon used Successfully !');
                                    }else{
                                        $couponStatus=trans('home.Sorry can not apply this Coupon');
                                    }
                                }


                                if($checkCoupon->coupon_type=='user'){
                                    $CouponUser=CouponUser::where('user_id',Auth::user()->id)->where('coupon_id',$checkCoupon->id)->first();
                                    if($CouponUser){
                                        if($checkCoupon->value_type == 'value'){
                                            $discount= $checkCoupon->value ;
                                        }else{
                                            $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                        }

                                        ///// apply coupon to cart///////
                                        $userCart->coupon_id=$checkCoupon->id;
                                        $userCart->coupon_discount=$discount;
                                        $userCart->total_price=$userCart->products_price - $discount;
                                        $userCart->save();
                                        $couponStatus=trans('home.Coupon used Successfully !');

                                    }else{
                                        $couponStatus=trans('home.Sorry can not apply this Coupon');
                                    }
                                }


                                if($checkCoupon->coupon_type=='region'){
                                    $couponRegionIds=CouponRegion::where('coupon_id',$checkCoupon->id)->pluck('region_id')->toArray();
                                    $userPrimaryAddress=Address::where('id',Auth::user()->id)->where('is_primary',1)->first();

                                    if(in_array($userPrimaryAddress->region_id,$couponRegionIds)){

                                        if($checkCoupon->value_type == 'value'){
                                            $discount= $checkCoupon->value ;
                                        }else{
                                            $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                        }

                                        ///// apply coupon to cart///////
                                        $userCart->coupon_id=$checkCoupon->id;
                                        $userCart->coupon_discount=$discount;
                                        $userCart->total_price=$userCart->products_price - $discount;
                                        $userCart->save();
                                        $couponStatus=trans('home.Coupon used Successfully !');

                                    }else{
                                        $regions=implode(",", $couponRegions);
                                        $couponStatus=trans('home.Sorry this Coupon  not Available for your Region');
                                    }
                                }

                                if($checkCoupon->coupon_type=='free_shipping'){
                                    $couponRegionIds=CouponRegion::where('coupon_id',$checkCoupon->id)->pluck('region_id')->toArray();
                                    $userPrimaryAddress=Address::where('id',Auth::user()->id)->where('is_primary',1)->first();

                                    if(in_array($userPrimaryAddress->region_id,$couponRegionIds)){

                                        if($checkCoupon->value_type == 'value'){
                                            $discount= $checkCoupon->value ;
                                        }else{
                                            $discount=((($userCart->products_price  * $checkCoupon->value) / 100 ));
                                        }

                                        ///// apply coupon to cart///////
                                        $userCart->coupon_id=$checkCoupon->id;
                                        $userCart->coupon_discount=$discount;
                                        $userCart->total_price=$userCart->products_price - $discount;
                                        $userCart->save();
                                        $couponStatus=trans('home.Coupon used Successfully !');

                                    }else{
                                        $regions=implode(",", $couponRegions);
                                        $couponStatus=trans('home.Sorry this Coupon  not Available for your Region');
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        \Session::put('check_coupon',$couponStatus);
        return response()->json([$couponStatus,$discount,$cartCouponProductsCount]);
    }
}
