<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Coupon;
use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use App\Models\ShippingMethod;
use App\Models\Stock;
use Flasher\Prime\Stamp\ViewStamp;
use Illuminate\Support\Facades\Session;

class CartWebController extends Controller
{
    public function index(){
        $data['shipping_methods'] = ShippingMethod::whereStatus(1)->get();
        if(auth()->check()){
            $cart = Cart::whereUserId(auth()->user()->id)->first();
        }else{
            $cart = GuestCart::where('session_id',Session::get('session_id'))->first();
        }

        if($cart && $cart->coupon_id)
        {
            $coupon_code =Coupon::find($cart->coupon_id)->code ;
            $coupon = $this->checkCoupon($coupon_code);
            if(is_string($coupon)){
                $cart->coupon_id = '';
                $cart->coupon_discount = '';
                $cart->save();

            }else{
                $data['coupon'] = $coupon;

            }
        }
        return view('old-userBoard.shoppingCart',$data);
    }

    public function indexWithCoponCoupon(){
        if(request('code')){
            $data['coupon'] = $this->checkCoupon() ;
            if (is_string($data['coupon'])) return redirect()->back()->withErrors($data['coupon']);

            return  redirect()->back()->with('data',$data);
        }
        return  redirect()->back();
    }


    public function store(CartRequest $request){
        try {
            $group = Stock::find(request('group_id'));
        if(auth()->check()){
            $cart = Cart::where('user_id', auth()->user()->id )->first();
            if (!$cart) {
                $cart = new Cart();
                $cart->user_id =auth()->user()->id ;
                $cart->save();
            }
             $status =  $this->addToAuthProductCart();
             if ($status) {
                $carts = CartProduct::where('user_id',auth()->user()->id)->with('group')->get();
                $cart->products_price = $carts->sum(function($product){return $product->totalProduct??0;});
                $cart->total_price = $carts->sum(function($product){return $product->totalProduct??0;});
                $cart->save();
             }
        }else{
            $cart = GuestCart::where('session_id', Session::get('session_id'))->first();

            if (!$cart) {
                Session::put('session_id', date('YmdHisuu'));
                $cart = new GuestCart();
                $cart->session_id =Session::get('session_id');
                $cart->save();
            }
            $status =  $this->addToGuestProductCart();
            if ($status) {
                $carts = GuestCartProduct::where('session_id',Session::get('session_id'))->where('guest_cart_id',$cart->id)->with('group')->get();
                $cart->products_price = $carts->sum(function($product){return $product->totalProduct??0;});
                $cart->total_price = $carts->sum(function($product){return $product->totalProduct??0;});
                $cart->save();
            }
        }
        if(!$status ){
            return response()->json(['status'=>false,'message'=>__('home.available') .' '. __('home.quantity') .': '.$group->stock ]);

        }
        $carts =view('website.appendes.products.carts.add_to_cart_header',['cartsPub'=>$carts])->render();
        return response()->json(['status'=>true,'message'=>__('home.your_product_successfully_added_to_your_cart'),'html_cart'=>$carts, $group]);

        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>'Error: ' . $ex->getMessage() . ' in file ' . $ex->getFile() . ' on line ' . $ex->getLine()]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }
       }


    public function destroy($id){
        try {
            if(auth()->check()){
                $cartPro = CartProduct::find($id);
                if($cartPro){
                    $cartPro->delete();
                    $carts = CartProduct::where('user_id',auth()->user()->id)->with('group')->get();
                    $cartsView =view('website.appendes.products.carts.add_to_cart_header',['cartsPub'=>$carts])->render();
                    $cart = Cart::where('user_id', auth()->user()->id )->first();
                    if (count($carts)>0) {
                        $cart->products_price = $carts->sum(function($product){return $product->totalProduct??0;});
                        $cart->total_price = $carts->sum(function($product){return $product->totalProduct??0;});
                        $cart->save();
                    }else{
                        $cart->delete();

                    }
                    return response()->json(['status'=>true,'message'=>__('home.your_product_deleted_successfully_from_your_cart'),'html_cart'=>$cartsView]);
                }
            }else{
                $cartPro = GuestCartProduct::find($id);
                if($cartPro){
                    $cartPro->delete();
                    $carts = GuestCartProduct::where('session_id',Session::get('session_id'))->with('group')->get();
                    $cartsView =view('website.appendes.products.carts.add_to_cart_header',['cartsPub'=>$carts])->render();
                    $cart = GuestCart::where('session_id',Session::get('session_id') )->first();
                    if (count($carts)>0) {
                        $cart->products_price = $carts->sum(function($product){return $product->totalProduct??0;});
                        $cart->total_price = $carts->sum(function($product){return $product->totalProduct??0;});
                        $cart->save();
                    }else{
                        $cart->delete();

                    }
                    return response()->json(['status'=>true,'message'=>__('home.your_product_deleted_successfully_from_your_cart'),'html_cart'=>$cartsView]);
                }

            }

            return response()->json(['status'=>false,'message'=>__('home.an error occurred')]);
        } catch (\Exception $ex) {
            if(request()->ajax()){
                return response()->json(['status'=>false,'message'=>'Error: ' . $ex->getMessage() . ' in file ' . $ex->getFile() . ' on line ' . $ex->getLine()
            ]);
            }
            if(env('APP_DEBUG')){
                dd($ex->getMessage());
            }

            return abort(500,__('home.an error occurred please connect with developer to solve it'));
        }

    }


    private function checkCoupon($code= null){
        $couponBuilder = Coupon::whereCode(request('code')??$code);
        $coupon = $couponBuilder->isValid()->first() ;
        $product_carts = auth()->user()->cartProducts;
        $total = count($product_carts)? $product_carts->sum(function ($cartProduct) {return $cartProduct->total_product;}): 0 ;
        $new_price = (object)[];
        // if (!$coupon)return response()->json(['stutas'=> false,'message'=>__('home.Sorry Coupon Not Found')]);
        // if (!$couponBuilder->isValid())return response()->json(['stutas'=> false,'message'=>__('home.Sorry this is Expired Coupon')]);
        // if ($couponBuilder->couponUsed()->count() >= $coupon->max_used || $couponBuilder->isAuthUsed())return response()->json(['stutas'=> false,'message'=>__('home.This Coupon already in use')]);
        // if ($coupon->order_min_price > request('total_after_all_discount'))return response()->json(['stutas'=> false,'message'=>__('home.Sorry Coupon only valid for price above')]);
        if (!$coupon)return __('home.Sorry Coupon Not Found');
        if (!$couponBuilder->isValid())return __('home.Sorry this is Expired Coupon');
        if ($coupon->couponUsed()->count() >= $coupon->max_used || $coupon->isAuthUsed())return __('home.This Coupon already in use') ;
        if ($coupon->order_min_price >  $total )return __('home.Sorry Coupon only valid for price above');
        if ( $total <= 0 )return __('home.an error occurred');
        $new_price->total = $coupon->value_type == 'percentage' ?  $total - (( $total * $coupon->value) /100) :   $total - $coupon->value ;
        $new_price->value = $coupon->value_type == 'percentage' ? (( $total* $coupon->value) /100) :   $coupon->value ;
        $new_price->name  = $coupon->name ;
        $new_price->coupon_id  = $coupon->id ;
        $cart = Cart::where('user_id', auth()->user()->id )->first();
        if ($cart) {
            $cart->coupon_id = $coupon->id;
            $cart->coupon_discount = $new_price->value;
            $cart->total_price =  $cart->products_price - $new_price->value;

            $cart->save();
        }
        // return response()->json(['stutas'=> false,'message'=>__('home.valid coupon'),'coupon'=>$new_price]);
        return $new_price ;
    }

    // private functions
    private function addToAuthProductCart(){

        $user_id = auth()->user()->id;
        $cart = Cart::where('user_id', $user_id )->first();
        $group_id = request('group_id');
        $quantity = request('quantity');
        $group = Stock::find($group_id);
        $cartProduct = CartProduct::where('user_id',$user_id)->where('group_id',$group_id)->first();
        if ($cartProduct) {
            if(request('in_cart')){
                if(!($quantity > $group->stock) && $quantity > 0){
                    return $cartProduct->update(['quantity'=> $quantity,'cart_id'=>$cart->id]);
                }else{
                    return false ;
                }
            }
            if(!(($cartProduct->quantity + $quantity) > $group->stock) && $quantity > 0 ){
                return $cartProduct->update(['quantity'=> ( $cartProduct->quantity + $quantity)]);
            }else{
                return false ;
            }
        }
        if(!($quantity > $group->stock)  && $quantity > 0){
            return CartProduct::create(['group_id'=>$group_id,'user_id'=>$user_id,'quantity'=>$quantity,'cart_id'=>$cart->id]);
        }else{
            return false ;
        }
    }


    private function addToGuestProductCart(){
        $session_id = Session::get('session_id');
        $cart = GuestCart::where('session_id',$session_id )->first();
        $group_id = request('group_id');
        $quantity = request('quantity');
        $group = Stock::find($group_id);
        $cartProduct = GuestCartProduct::where('session_id',$session_id)->where('group_id',$group_id)->where('guest_cart_id',$cart->id)->first();
        if ($cartProduct) {
            if(request('in_cart')){
                if(!($quantity > $group->stock)  && $quantity > 0){
                    return $cartProduct->update(['quantity'=> $quantity ]);

                }else{
                    return false ;
                }
            }
            if(!(($cartProduct->quantity + $quantity) > $group->stock) && $quantity > 0){
                return $cartProduct->update(['quantity'=> ( $cartProduct->quantity + $quantity)]);

            }else{
                return false ;
            }
        }
        if(!($quantity >$group->stock)  && $quantity > 0){
            return GuestCartProduct::create(['group_id'=>$group_id,'session_id'=>$session_id,'quantity'=>$quantity,'guest_cart_id'=>$cart->id]);
        }else{
            return false ;
        }

     }
}
