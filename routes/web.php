<?php


use Illuminate\Support\Facades\Artisan;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;



/////google Auth////
Route::get('login/google', 'Auth\LoginController@redirectToGoogleProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleProviderCallback');


Route::get('paymob_txn_response_callback','PlaceOrderController@weAcceptCardPaymentCallback');
Route::get('paymob_txn2_response_callback','PlaceOrderController@weAcceptKioskCallback');

Route::group(['middleware'=>['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],'prefix' => LaravelLocalization::setLocale() ],function(){

    /////// site map///
    require base_path('routes/sitemap/sitemap.php');
    require base_path('routes/website/home.php');

    Route::get('deals','WebsiteController@deals');
    Route::get('featured','WebsiteController@featuredProducts');
    Route::get('/categories', 'WebsiteController@getCategories');
    Route::get('sub-categories/{name}/{id}', 'WebsiteController@getSubCategories');
    Route::get('category/{name}/{id}/products', 'WebsiteController@getCategoryProducts');
    Route::get('searchAutoComplete','WebsiteController@autoCompletesearch');
    Route::get('searchResult','WebsiteController@searchResult');

    Route::get('page/{link}','WebsiteController@getPage');
    Route::get('trendings','WebsiteController@getBlogs');
    Route::get('trending/{link}','WebsiteController@getBlogPage');
    Route::get('blog/{link}','WebsiteController@getBlogPage');
    Route::get('blogs/{link}','WebsiteController@getCategoryBlogs');
    Route::get('blogs','WebsiteController@getBlogs');
    Route::post('/getRegions','WebsiteController@getRegions');
    Route::post('/getAreas','WebsiteController@getAreas');
    Route::get('brand/{link}','WebsiteController@getBrandProducts');
    Route::get('galleryVideos','WebsiteController@getGalleryVideos');
    Route::get('winners','WebsiteController@getWinners');
    Route::get('maintenance','WebsiteController@getMaintenance');
    Route::post('save-maintenance','WebsiteController@saveMaintenanceRequest');
    Route::get('branches','WebsiteController@getBrnaches');
    Route::post('getRegionsBranches','WebsiteController@getRegionsBranches');
    Route::post('branchesFilter','WebsiteController@branchesFilter');
    Route::get('terms&condation',function(){
        return view('website.terms');
    });



    Route::get('user/wish-list', 'OldUserBoardController@wishList');
    Route::post('remove/wishlist/{id}','OldUserBoardController@removeWishlist');
    Route::post('addWishlist','UserBoardController@addWishlist');
    Route::get('user/compareList', 'UserBoardController@compareList');
    Route::post('remove/compareList/{id}','UserBoardController@removeCompareList');
    Route::post('addCompareList','UserBoardController@addCompareList');

    Route::post('cardAddToCart','UserBoardController@cardAddToCart');
    Route::post('carts/coupon','CartWebController@indexWithCoponCoupon');
    Route::resource('carts', 'CartWebController');
//    Route::post('addToCart','UserBoardController@addToCart');
    Route::post('showAddCart','UserBoardController@showCart');
    Route::get('shopping-cart','UserBoardController@getShoppingCart')->name('shopping-cart');
    Route::post('removeCartProduct','UserBoardController@removeCartProduct');
    Route::post('removeCartAllProduct','UserBoardController@removeCartAllProduct');
    Route::post('changeCartProductQuantity','UserBoardController@changeCartProductQuantity');

    Route::post('refreshCart','UserBoardController@refreshCart');
    Route::post('refreshWishlist','UserBoardController@refreshWishlist');
    Route::post('subscribe-newsletter','WebsiteController@subscribeNewsletter');

    Route::get('bestSeller','WebsiteController@getBestSeller');

    Route::post('add-and-shoppiong-cart','WebsiteController@addAndChoppiongCart')->name('addAndChoppiongCart');

    Route::post('editAddress','UserBoardController@editAddressShow')->name('editAddress.show');
    Route::get('brands','WebsiteController@getBrands');
    Route::get('brand/{link}','WebsiteController@getBrandProducts');

    Route::post('get_option_price','UserBoardController@get_option_price');

    Route::get('order-checkOut','UserBoardController@checkOut');






});

Route::group(['middleware'=>['web','auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],'prefix' => LaravelLocalization::setLocale() ],function(){
    Route::resource('wishes', 'WishWebController');
    Route::get('user/account-settings', 'UserBoardController@accountSettings');
    Route::get('user/profile', 'UserBoardController@profile');
    Route::get('user/shipping-addresses', 'UserBoardController@shippingAddresses');
    Route::get('user/add/shipping-address','UserBoardController@addShippingAddress');
    Route::post('store/shipping-address','UserBoardController@storeAddress');
    Route::get('user/shipping-address/edit/{id}','UserBoardController@editshippingAddress');
    Route::get('user/edit-account','UserBoardController@editAccount');
    Route::post('update/accountSetting','UserBoardController@updateAccountSetting');
    Route::post('update/userAddress/{id}','UserBoardController@updateAddress');
    Route::post('make/userAddress/primary','UserBoardController@makeAddressPrimary')->name('makeAddressPrimary');
    Route::post('make/userAddress/primary/{id}','UserBoardController@makeAddressPrimary');

    Route::post('delete/userAddress/{id}','UserBoardController@deleteAddress');
    Route::get('user/orders','UserBoardController@orders');
    Route::get('user/orders','UserBoardController@orders');
    Route::post('check/coupon','CheckCouponController@checkCoupon');
    Route::post('placeOrder','PlaceOrderController@placeOrder');
    Route::get('order/{id}/completed','PlaceOrderController@orderComplete');
    Route::get('track-order/{id}','UserBoardController@trackOrder');
    Route::post('changeMethod','UserBoardController@changeMethod');
    Route::post('add/productReview','UserBoardController@addProductReview');
    Route::post('cancel/Order','UserBoardController@cancelOrder');
    Route::post('user/order_tracking','UserBoardController@orderTracking');
    Route::get('find-wishlist','UserBoardController@findwishlist');
    Route::post('find-wishlist','UserBoardController@getGiftWishList');
    Route::PATCH('users/{id}', 'UserController@update');

});

Route::group(['middleware'=>['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],'prefix' => LaravelLocalization::setLocale() ],function(){
    Route::group(['middleware'=>['admin','web'],'prefix'=>'admin'],function(){

        ////////////////////////////////// reports/////////////////////////////
        Route::get('order-report', 'ReportController@orderReportView');
        Route::post('order-report', 'ReportController@orderReportResult');
        Route::get('daily-report', 'ReportController@dailyReportView');
        Route::post('daily-report', 'ReportController@dailyReportResult');
        Route::get('monthely-report', 'ReportController@monthelyReportView');
        Route::post('monthely-report', 'ReportController@monthelyReportResult');
        Route::get('weekly-report', 'ReportController@weeklyReportView');
        Route::post('weekly-report', 'ReportController@weeklyReportResult');
        Route::get('product-report', 'ReportController@productReportView');
        Route::post('product-report', 'ReportController@productReportResult');
        Route::get('orderProducts-report', 'ReportController@ordersProductsReportView');
        Route::post('orderProducts-report', 'ReportController@ordersProductsReportResult');
        Route::resource('winners', 'WinnerController');
        Route::resource('branches', 'BrancheController');
        Route::resource('installmentPartners', 'InstallmentPartnerController');

        Route::get('top_header','TopHeaderController@index');
        Route::PATCH('top_header','TopHeaderController@update');
    });
});


Route::group(['middleware'=>['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],'prefix' => LaravelLocalization::setLocale() ],function(){
    Auth::routes();
    // Route::get('{slug}/','WebsiteController@checkUrl')->name('checkUrl');
});


//////////// clearing cach and cache config///////
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('optimize:clear');
    return 'DONE'; //Return anything
});
