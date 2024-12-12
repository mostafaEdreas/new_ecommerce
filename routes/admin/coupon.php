<?php

use Illuminate\Support\Facades\Route;

 Route::get('coupons', 'CouponController@index')->name('admin.coupons.index');

 Route::get('coupons/create', 'CouponController@create')->name('admin.coupons.create');

 Route::post('coupons', 'CouponController@store')->name('admin.coupons.store');

 Route::get('coupons/{coupon}/edit', 'CouponController@edit')->name('admin.coupons.edit');

 Route::patch('coupons/{coupon}', 'CouponController@update')->name('admin.coupons.update');

 Route::delete('coupons/{coupon}', 'CouponController@destroy')->name('admin.coupons.destroy');