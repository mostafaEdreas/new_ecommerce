<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class CheckLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($lang = Session::get('lang')) {
            App::setlocale($lang);
        }
        else {
            
            $lang = config('site_lang');
            App::setlocale($lang);
        }
        return $next($request);
    }
}
