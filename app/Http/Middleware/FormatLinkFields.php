<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FormatLinkFields
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $getDataFrom = ['name_','title_' ];
        $locales = ['ar' ,'en'] ;
        foreach ($getDataFrom as  $value) {
            foreach ($locales as $locale) {
                $real_value = $value.$locale ;
                if($request->has('link_'.$locale) && is_null($request->{'link_'.$locale} ) && $request->has($real_value) ){
                    $request->merge([
                        'link_'.$locale => str_replace(' ', '-', strtolower($request->{$real_value}))
                    ]);
                }
            }
        }
        return $next($request);
    }
}
