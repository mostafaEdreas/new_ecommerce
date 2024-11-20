<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Address;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Configration;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\TopHeader;
use App\Models\Service;
use App\Models\Product;
use App\Models\CartProductOption;
use App\Models\GuestCart;
use App\Models\GuestCartProduct;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register():void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

        Schema::defaultStringLength(191);

        view()->composer('*', function($view){
            $wishCount = 0 ;
            if(auth()->check()){
                $cartsPub = CartProduct::where('user_id',auth()->user()->id)->with('group')->whereHas('group',function($q){
                    $q->whereHas('product');
                })->get();
                $wishCount = Wishlist::where('user_id',auth()->user()->id)->whereHas('group',function($q){
                    $q->whereHas('product');
                })->count();
            }else{
                $cartsPub = GuestCartProduct::where('session_id',Session::get('session_id'))->whereHas('group',function($q){
                    $q->whereHas('product');
                })->with('group')->get();
            }
            $setting = Setting::first();
            $lang = LaravelLocalization::getCurrentLocale();
            App::setlocale($lang);

            $configration = Configration::where('lang',$lang)->first();
            $menus = MenuItem::where('status',1)->where('parent_id',0)->orderBy('order','ASC')->get();
            // $pages = Page::where('status',1)->get();
            // $menuMainCategories=Category::where('status',1)->where('menu',1)->where('parent_id',0)->orderBy('order','ASC')->get();
            // $menuBrands=Brand::where('status',1)->where('menu',1)->get();
            $mainCategories=Category::where('status',1)->where('parent_id',0)->orderBy('order','ASC')->get();
            // $services = Service::where('status',1)->take(4)->get();
            $lang=LaravelLocalization::getCurrentLocale();
            // $about = About::first();
            // $home_categories= Category::where('status',1)->where('menu',1)->where('parent_id',0)->orderBy('order','ASC')->get();
            // $search_categories= Category::where('status',1)->orderBy('order','ASC')->get();
            $TopHeader =TopHeader::first();
            // $menu_products = Product::where('status',1)->where('featurd',1)->get();


            // $cartCount=Session::get('cart')?count(Session::get('cart')):0;
            // $wishCount=Session::get('wishlist')?count(Session::get('wishlist')):0;
            // $productsPrice = 0;
            // $cartProds=[];
            // $couponDiscount=0;
            // $totalPrice = 0;
            // $productPrices=[];

            $addresses = Address::get();








            if(!Auth::check()){
                if(Session::has('session_id')){
                    $guestWishlist = Session::get('wishlist');
                    if($guestWishlist){
                        $wishProds = Product::whereIn('id',$guestWishlist)->get();
                    }else{
                        $wishProds=[];
                    }
                    $guestCart=GuestCart::where('session_id',Session::get('session_id'))->first();
                    // $cartProds=GuestCartProduct::where('guest_cart_id',$guestCart->id)->select(DB::raw('price * quantity as price'),'price as prod_price','id','quantity','product_id','guest_cart_id')->get();
                    // $cartCount = $cartProds->count();

                    // foreach($cartProds as $cartProduct){
                    //     $cartProductOptionsPrice= CartProductOption::where('cart_product_id',$cartProduct->id)->sum('price');
                    //     array_push($productPrices,$cartProduct->price + ($cartProductOptionsPrice * $cartProduct->quantity));
                    // }
                    // $productsPrice=array_sum($productPrices);

                    // $totalPrice = $productsPrice;
                }else{
                    $wishProds = [];
                }

            }

            if(Auth::check()){
                $cart = Cart::where('user_id',Auth::user()->id)->first();
                if(!$cart){
                    /////create user cart///
                    $cart= new Cart();
                    $cart->user_id=Auth::user()->id;
                    $cart->save();
                }
                // $cartCount=CartProduct::where('user_id',Auth::user()->id)->where('cart_id',$cart->id)->count();
                // $wishCount= Wishlist::where('user_id',Auth::user()->id)->count();

                $wishListProducts_ids =Wishlist::where('user_id',Auth::user()->id)->pluck('product_id')->toArray();
                $wishProds = Product::whereIn('id',$wishListProducts_ids)->get();

                // $cartProds= CartProduct::where('cart_id',$cart->id)->select(DB::raw('price * quantity as price'),'price as prod_price','id','quantity','product_id','cart_id')->get();
                // foreach($cartProds as $cartProduct){
                //     $cartProductOptionsPrice= CartProductOption::where('cart_product_id',$cartProduct->id)->sum('price');
                //     array_push($productPrices,$cartProduct->price + ($cartProductOptionsPrice * $cartProduct->quantity));
                // }
                // $productsPrice=array_sum($productPrices);

                // $couponDiscount = $cart->coupon_discount;
                // $totalPrice = $productsPrice - $couponDiscount;
            }



            // View::share('language', $lang);
            View::share('setting', $setting);
            View::share('configration', $configration);
            View::share('menus', $menus);
            // View::share('pages', $pages);
            View::share('lang', $lang);
            // View::share('cartCount', $cartCount);
            View::share('wishCount', $wishCount);
            // View::share('menuMainCategories', $menuMainCategories);
            // View::share('productsPrice', $productsPrice);
            // View::share('couponDiscount', $couponDiscount);
            // View::share('totalPrice', $totalPrice);
            // View::share('cartProds', $cartProds);
            View::share('mainCategories', $mainCategories);
            // View::share('menuBrands', $menuBrands);
            // View::share('services', $services);
            // View::share('about', $about);
            // View::share('home_categories', $home_categories);
            // View::share('search_categories', $search_categories);
            View::share('TopHeader', $TopHeader);
            // View::share('menu_products', $menu_products);
            View::share('wishProds', $wishProds);
            View::share('cartsPub', $cartsPub);
            View::share('addresses', $addresses);

        });
    }
}
