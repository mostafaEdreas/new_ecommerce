<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Page;
use App\Models\BlogItem;
use DB;

class SiteMapController extends Controller
{

    public function indexSitemap(){
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }

    public function allProductSitemap(){
        $products= Product::where('status',1)->latest()->get();
        return response()->view('sitemap.all-products-sitemap', [
    	      'products'=>$products,
    	])->header('Content-Type', 'text/xml');
    }

    public function categoriesSitemap(){
        $categories = Category::where('status',1)->latest()->get();
        return response()->view('sitemap.categories-sitemap', [
    	      'categories' => $categories,
    	])->header('Content-Type', 'text/xml');
    }

    public function pagesSitemap(){
        $pages = Page::latest()->get();
        return response()->view('sitemap.pages-sitemap', [
    	      'pages' => $pages,
    	])->header('Content-Type', 'text/xml');
    }

    public function blogsSitemap(){
        $blogs = BlogItem::latest()->get();
        return response()->view('sitemap.blogs-sitemap', [
    	      'blogs' => $blogs,
    	])->header('Content-Type', 'text/xml');
    }

    public function brandsSitemap (){
        $brands= Brand::latest()->where('status',1)->get();
        return response()->view('sitemap.brands-sitemap', [
    	      'brands' => $brands,
    	])->header('Content-Type', 'text/xml');
    }

    public function productOffersSitemap(){
        $productIds= DB::table('product_discounts')->whereRaw('(now() between start_date and end_date)')->pluck('product_id')->toArray();
        $products = Product::whereIn('id',$productIds)->where('status',1)->get();
        return response()->view('sitemap.productOffers-sitemap', [
    	      'products'=>$products,
    	])->header('Content-Type', 'text/xml');
    }

    public function trendingProductSitemap(){
        $products= Product::where('featurd',1)->where('status',1)->latest()->get();
        return response()->view('sitemap.all-products-sitemap', [
    	      'products'=>$products,
    	])->header('Content-Type', 'text/xml');
    }




}
