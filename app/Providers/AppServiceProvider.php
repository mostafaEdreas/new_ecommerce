<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

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


    public function boot()
    {

        Schema::defaultStringLength(191);

        view()->composer('*', function($view){
            $lang = LaravelLocalization::getCurrentLocale();

            View::share('lang', $lang);
        });
    }
}
