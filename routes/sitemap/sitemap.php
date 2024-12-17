<?php

use Illuminate\Support\Facades\Route;

    Route::get('/sitemap.xml','SiteMapController@indexSitemap');
    Route::get('/all-products-sitemap.xml','SiteMapController@allProductSitemap');
    Route::get('/brands-sitemap.xml','SiteMapController@brandsSitemap');
    Route::get('/categories-sitemap.xml','SiteMapController@categoriesSitemap');
    Route::get('/pages-sitemap.xml','SiteMapController@pagesSitemap');
    Route::get('/trendings-sitemap.xml','SiteMapController@blogsSitemap');
    Route::get('/product-offers-sitemap.xml','SiteMapController@productOffersSitemap');
    Route::get('/trending-products-sitemap.xml','SiteMapController@trendingProductSitemap');
    Route::get('/all-product-googl-sitemap.xml','SiteMapController@allProductGooglSitemap');