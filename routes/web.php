<?php

use App\Http\Controllers\AboutStrucController;
use App\Http\Controllers\WebsiteController;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;



// //facebook auth///
// Route::get('login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
// Route::get('login/facebook/callback', 'Auth\LoginController@handleFacebookProviderCallback');

/////google Auth////
Route::get('login/google', 'Auth\LoginController@redirectToGoogleProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleProviderCallback');


Route::get('paymob_txn_response_callback','PlaceOrderController@weAcceptCardPaymentCallback');
Route::get('paymob_txn2_response_callback','PlaceOrderController@weAcceptKioskCallback');

Route::group(['middleware'=>['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],'prefix' => LaravelLocalization::setLocale() ],function(){

    /////// site map///
    Route::get('/sitemap.xml','SiteMapController@indexSitemap');
    Route::get('removeSession/remove',function(){
        session()->forget('session_id');
        return  session()->get('session_id')??'ok';
    });
    Route::get('/all-products-sitemap.xml','SiteMapController@allProductSitemap');
    Route::get('/brands-sitemap.xml','SiteMapController@brandsSitemap');
    Route::get('/categories-sitemap.xml','SiteMapController@categoriesSitemap');
    Route::get('/pages-sitemap.xml','SiteMapController@pagesSitemap');
    Route::get('/trendings-sitemap.xml','SiteMapController@blogsSitemap');
    Route::get('/product-offers-sitemap.xml','SiteMapController@productOffersSitemap');
    Route::get('/trending-products-sitemap.xml','SiteMapController@trendingProductSitemap');
    Route::get('/all-product-googl-sitemap.xml','SiteMapController@allProductGooglSitemap');

    Route::get('/lang/{lang}', 'AdminController@setlang');
    Route::get('/','WebsiteController@home');
    Route::get('about-us','WebsiteController@aboutUs');
    Route::get('contact-us','WebsiteController@contactUs');
    Route::post('save/contact-us','WebsiteController@saveContactUs');
    Route::get('deals','WebsiteController@deals');
    Route::get('featured','WebsiteController@featuredProducts');
    Route::get('/categories', 'WebsiteController@getCategories');
    Route::get('sub-categories/{name}/{id}', 'WebsiteController@getSubCategories');
    Route::get('category/{name}/{id}/products', 'WebsiteController@getCategoryProducts');
    Route::get('/products', 'WebsiteController@getProducts');
    Route::get('searchAutoComplete','WebsiteController@autoCompletesearch');
    Route::get('searchResult','WebsiteController@searchResult');

    Route::get('product/{link}','WebsiteController@getProductDetails');
    Route::post('product/{link}','WebsiteController@getProductDetails');
    Route::get('page/{link}','WebsiteController@getPage');
    Route::get('trendings','WebsiteController@getBlogs');
    Route::get('trending/{link}','WebsiteController@getBlogPage');
    Route::get('blog/{link}','WebsiteController@getBlogPage');
    Route::get('blogs/{link}','WebsiteController@getCategoryBlogs');
    Route::get('blogs','WebsiteController@getBlogs');
    Route::post('/getRegions','WebsiteController@getRegions');
    Route::post('/getAreas','WebsiteController@getAreas');
    Route::get('brand/{link}','WebsiteController@getBrandProducts');
    Route::get('category/{link}','WebsiteController@getCategory');
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
        require base_path('routes/admin/about.php');
        require base_path('routes/admin/aboutStrucs.php');
        require base_path('routes/admin/sliders.php');
        require base_path('routes/admin/brands.php');
        require base_path('routes/admin/categories.php');
        require base_path('routes/admin/discounts.php');
        Route::get('', 'AdminController@admin');
        Route::get('/switch-theme', 'AdminController@switchTheme');
        Route::get('translations', 'AdminController@translations');
        Route::post('{name}/up/{ids}','AdminController@updatestatus');
        Route::resource('/settings', 'SettingController');

        Route::resource('teams', 'TeamController');
        Route::resource('counters', 'CounterController');
        Route::resource('testimonials', 'TestimonialController');
        Route::get('free_shipping', 'SettingController@get_free_shipping');
        Route::post('update_free_shipping', 'SettingController@update_free_shipping');


        Route::resource('/configrations', 'ConfigrationController');
        Route::resource('users', 'UserController');
        Route::get('user-admins', 'UserController@admins');
        Route::resource('roles', 'RoleController');
        Route::resource('permissions', 'PermissionController');

        Route::resource('/countries', 'CountryController');
        Route::resource('/regions', 'RegionController');
        Route::resource('/areas', 'AreaController');
        Route::resource('/colors', 'ColorController');
        Route::resource('/attributes', 'AttributeController');
        Route::post('removeAttributeValue', 'AttributeController@removeAttributeValue')->name('removeAttributeValue');
        Route::post('updateAttributeValue', 'AttributeController@updateAttributeValue')->name('updateAttributeValue');

        Route::resource('/products', 'ProductController');
        ///////// product operations///////////
        Route::post('products/sub-categories', 'ProductController@getSubCategories');
        Route::post('products/generate-barcode', 'ProductController@generateBarcode');
        Route::post('products/changeCategory/{id}', 'ProductController@changeCategory');
        Route::post('products/changeColors/{id}', 'ProductController@changeColors');
        Route::post('products/uploadImages', 'ProductController@uploadImages');
        Route::post('products/removeUploadImages', 'ProductController@removeUploadImages');
        Route::post('products/sub-sub-categories', 'ProductController@productCategoryAttributes');
        Route::post('/productCategoryAttributes', 'ProductController@productCategoryAttributes');
        Route::post('product/deleteImege', 'ProductController@deleteImege');
        Route::post('product/updatePriceList', 'ProductController@updatePriceList');
        Route::delete('products/remove-product-attribute-value/{id}', 'ProductController@removeProductAttributeValue');
        Route::post('products/add-product-attribute-value', 'ProductController@addProductAttributeValue');
        Route::get('products/appends/doesntHaveAttr/{id}', 'ProductController@getDoesntHaveAttr');
        Route::get('products/appends/doesntHaveVal', 'ProductController@getDoesntHaveVal');
        Route::get('products/appends/doesntHaveAttr/{id}', 'ProductController@getDoesntHaveAttr');
        Route::delete('products/images/delete-image/{image_id}', 'ProductController@deleteFromImages');
        Route::post('products/images/save-image/{product_id}', 'ProductController@saveToImages');
        Route::put('products/product-attribute/save-price', 'ProductController@addPriceToValue');
        Route::get('products/product-attribute/handle-attributes', 'ProductController@handleAttributesInProduct');
        Route::post('products/stock/new-group/{product_id}', 'ProductController@newGroupForStockAndPrice');
        Route::post('products/stock/add-to-group/{stock_id}', 'ProductController@addToStock');
        Route::delete('products/stock/delete-value', 'ProductController@removeValueFromStock');





        Route::resource('pages', 'PageController');
        Route::resource('menus', 'MenuController');
        Route::resource('menu-items', 'MenuItemController');

        Route::post('menuTypeValue', 'MenuItemController@menuTypeValue')->name('menuTypeValue');
        Route::resource('intro-sliders', 'IntroSliderController');
        Route::resource('home-sliders', 'HomeSliderController');
        Route::resource('offers-sliders', 'OfferSliderController');
        Route::resource('shipping-methods', 'ShippingMethodController');
        Route::resource('payment-methods', 'PaymentMethodController');
        Route::resource('coupons', 'CouponController');
        Route::post('couponType', 'CouponController@couponType')->name('couponType');
        Route::resource('deliveries', 'DeliveryController');
        Route::resource('services', 'ServiceController');

        Route::resource('orders', 'OrderController');
        Route::post('orders/changeStatus', 'OrderController@changeOrderStatus');
        Route::post('orders/changeOrderPaymentStatus', 'OrderController@changeOrderPaymentStatus')->name('changeOrderPaymentStatus');
        Route::get('order/{id}/invoice', 'OrderController@orderInvoice');
        Route::post('order/{id}/cancel', 'OrderController@orderCancel');
        Route::post('orders/filter', 'OrderController@orderFilter');
        Route::post('order/delivery/{id}', 'OrderController@OrderDelivey');


        Route::resource('menus', 'MenuController');
        Route::resource('menu-items', 'MenuItemController');
        Route::post('menuTypeValue', 'MenuItemController@menuTypeValue')->name('menuTypeValue');

        Route::resource('contact-us-messages', 'ContactusController');
        Route::resource('pages', 'PageController');
        Route::resource('blog-categories', 'BlogCategoryController');
        Route::resource('blog-items', 'BlogItemController');
        Route::resource('home-images', 'HomeImageController');

        Route::resource('gallery-images', 'GalleryImageController');
        Route::post('gallery-images/deleteImege', 'GalleryImageController@deleteImege');
        Route::post('gallery-images/reorder','GalleryImageController@reorderImeges');
        Route::get('gallery-image/create-pluck','GalleryImageController@createPluck');
        Route::post('gallery-images/uploadImages','GalleryImageController@uploadImages');
        Route::post('gallery-images/removeUploadImages','GalleryImageController@removeUploadImages');
        Route::post('gallery-images/storePluck','GalleryImageController@storePluck');
        Route::resource('gallery-videos', 'GalleryVideoController');
        Route::post('gallery-videos/reorder','GalleryVideoController@reorderVideos');

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
        Route::resource('seo-assistant', 'SeoAssistantContoller');
        Route::resource('installmentPartners', 'InstallmentPartnerController');

        Route::get('top_header','TopHeaderController@index');
        Route::PATCH('top_header','TopHeaderController@update');
    });
});


Route::group(['middleware'=>['web','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],'prefix' => LaravelLocalization::setLocale() ],function(){
    Auth::routes();
    Route::get('{slug}/','WebsiteController@checkUrl')->name('checkUrl');
});


//////////// clearing cach and cache config///////
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('optimize:clear');
    return 'DONE'; //Return anything
});
