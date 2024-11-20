<?php

namespace App\Http\Middleware;

use App\Models\BlogItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\Service;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class EditSlugInUrl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $slugLang = $request->segment(1);
        App::setLocale($slugLang);
        $currentLang = App::getLocale();
        $test_lang = Setting::first()->default_lang;        
        
        if ($slugLang == $currentLang) {
            $url = $request->url();

            
            if ($request->segment(2) == 'blog') {
                $blog = BlogItem::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/blog/{$blog->{'link_' . $slugLang}}");
                $url = urldecode($url);
                if($redirectUrl == $url){
                    return $next($request);
                }else{
                    return redirect($redirectUrl);
                }
            }
            
             if ($request->segment(2) == 'service') {
                $service = Service::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/service/{$service->{'link_' . $slugLang}}");
                $url = urldecode($url);
                if($redirectUrl == $url){
                    return $next($request);
                }else{
                    return redirect($redirectUrl);
                }
            } 
            
            

            if ($request->segment(2) == 'product') {
                $product = Product::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/product/{$product->{'link_' . $slugLang}}");
                $url = urldecode($url);
                if($redirectUrl == $url){
                    return $next($request);
                }else{
                    return redirect($redirectUrl);
                }
            } 
            
            if ($request->segment(2) == 'category') {
                $category = Category::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/category/{$category->{'link_' . $slugLang}}");
                $url = urldecode($url);
                if($redirectUrl == $url){
                    return $next($request);
                }else{
                    return redirect($redirectUrl);
                }
            } 

            return $next($request);
        }

        if ($slugLang != $test_lang) {
            
            $url = $request->url();
            
            if ($request->segment(2) == 'blog') {
                $blog = BlogItem::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/blog/{$blog->{'link_' . $slugLang}}");
                if($redirectUrl != $url){
                    return redirect($redirectUrl);
                }   
            }
            
            if ($request->segment(2) == 'service') {
                $service = Service::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/service/{$service->{'link_' . $slugLang}}");
                if($redirectUrl != $url){
                    return redirect($redirectUrl);
                }   
            }
            

            if ($request->segment(2) == 'product') {
                $product = Product::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/product/{$product->{'link_' . $slugLang}}");
                $url = urldecode($url);
                if($redirectUrl == $url){
                    return $next($request);
                }else{
                    return redirect($redirectUrl);
                }
            } 
            
            if ($request->segment(2) == 'category') {
                $category = Category::where("link_en", $request->segment(3))->orwhere("link_ar", $request->segment(3))->first();
                $redirectUrl = url("/$slugLang/category/{$category->{'link_' . $slugLang}}");
                $url = urldecode($url);
                if($redirectUrl == $url){
                    return $next($request);
                }else{
                    return redirect($redirectUrl);
                }
            } 
            return $next($request);
            
        }
    }
}
