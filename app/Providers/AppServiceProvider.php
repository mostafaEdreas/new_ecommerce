<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;
use App\Models\Configration;


use App\Models\TopHeader;

use Illuminate\Support\Facades\App;

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
        $configurations = Setting::all()->mapWithKeys(function ($config) {
            return ['site_'.$config->key => $config->value];
        });

        config()->set($configurations->toArray());
        Schema::defaultStringLength(191);
        view()->composer('*', function($view){
            // View::share('language', $lang);
        });
    }
}
