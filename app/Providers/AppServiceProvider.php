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
            $configurations = Cache::remember("settings_$lang", 3600, function () use ($lang) {
                return Setting::whereLang($lang)
                    ->orWhere('lang', 'all')
                    ->orWhereNull('lang')
                    ->get()
                    ->mapWithKeys(function ($config) {
                        return ['site_' . $config->key => $config->value];
                    })
                    ->toArray();
            });
            config()->set($configurations);
            View::share('lang', $lang);
        });
    }
}
