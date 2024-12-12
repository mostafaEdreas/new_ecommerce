<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Symfony\Component\HttpFoundation\Response;

class GlobalConfigMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = LaravelLocalization::getCurrentLocale();
        $configurations = Cache::remember("settings_$lang", 3600, function () use ($lang) {
            return Setting::whereLang($lang)
                ->orWhere('lang', 'all')
                ->orWhereNull('lang')
                ->get()
                ->mapWithKeys(function ($config) {

                    return ['site_' . $config->key => $config->real_value];
                })
                ->toArray();
        });
        $images = Cache::remember("settings_Images", 3600, function () use ($lang) {
            return Setting::whereLang($lang)
            ->where(function($q)use($lang){
                $q->whereLang($lang)
                ->orWhere('lang', 'all')
                ->orWhereNull('lang');
            })
                ->whereIn('key' ,Setting::IMAGES)
                ->get()
                ->mapWithKeys(function ($config) {
                    return ['image_' . $config->key => $config->value];
                })
                ->toArray();
        });

        $images_200 = Cache::remember("settings_Images_200", 3600, function () use ($lang) {
            return Setting::whereLang($lang)
            ->where(function($q)use($lang){
                $q->whereLang($lang)
                ->orWhere('lang', 'all')
                ->orWhereNull('lang');
            })
                ->whereIn('key' ,Setting::IMAGES)
                ->get()
                ->mapWithKeys(function ($config) {
                    return ['image_200_' . $config->key => $config->value_200];
                })
                ->toArray();
        });
        config()->set($configurations);
        config()->set($images);
        config()->set($images_200);
        return $next($request);
    }
}
