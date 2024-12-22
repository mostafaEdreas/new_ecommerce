<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    protected $namespace = 'App\Http\Controllers';
    protected $adminnamespace = 'App\Http\Controllers\Admin';
    protected $adminFiles = [
        'about.php',
        'aboutStrucs.php',
        'sliders.php',
        'brands.php',
        'categories.php',
        'discounts.php',
        'products.php',
        'menus.php',
        'shippingFees.php',
        'seo-assistant.php',
        'coupon.php',
        'admin.php',
        'attributes.php',
        'setting.php' ,
        'configrations.php',
        'deliveries.php',
        'pages.php' ,
        'permissions.php',
        'roles.php',
        'areas.php' ,
        'regions.php',
        'configrations.php' ,
        'countries.php' ,
        'orders.php',
        'contactUs.php',
    ];


    protected $websitenamespace = 'App\Http\Controllers\Website';
    protected $websiteFiles = [
        'home.php',
        'about.php' ,
        'products.php' ,
        'categories.php' ,
    ];
    protected $apinamespace = 'App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
            // Admin Routes
            Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'admin'])
                ->namespace($this->adminnamespace)
                ->prefix(LaravelLocalization::setLocale().'/admin')
                ->group(function () {
                    foreach ($this->adminFiles as $routeFile) {
                        require base_path('routes/admin/' . $routeFile);
                    }
            });

            // website Routes
            Route::middleware(['web', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])
                ->namespace($this->websitenamespace)
                ->prefix(LaravelLocalization::setLocale())
                ->group(function () {
                    foreach ($this->websiteFiles as $routeFile) {
                        require base_path('routes/website/' . $routeFile);
                    }
            });
        });
    }
}
