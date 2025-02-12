<?php

namespace App\Providers;

use App\Models\About;
use App\Models\Category;
use App\Models\Menu;
use App\Traits\Carts\CartTrait;
use App\Traits\Carts\GuestCartTrait;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\View;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class AppServiceProvider extends ServiceProvider
{
    use CartTrait , GuestCartTrait ;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register():void
    {
        //
    }


    public function boot()
    {

        Schema::defaultStringLength(191);

        view()->composer('*', function($view){
            $lang = LaravelLocalization::getCurrentLocale();

            // check user if auth and return the right model ;
            $cart = auth()->check() ? $this->getCart() : $this->getGuestCart();
            $menus = Menu::main()->active()->orderBy('order')->get();
            $public_categories = Category::active()->take(5)->get();
            $about = About::first();

            View::share('lang', $lang);
            View::share('cart', $cart);
            View::share('menus', $menus);
            View::share('public_categories', $public_categories);
            View::share('about', $about);
        });
    }
}
