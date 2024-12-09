<?php

use Illuminate\Support\Facades\Route;

Route::get('discounts/{product_id}','ProductController@discountIndex')->name('discounts.index');
Route::PATCH('discounts/{discount_id}','ProductController@discountUpdate')->name('discounts.update');
Route::post('discounts/','ProductController@discountStore')->name('discounts.store');
Route::delete('discounts/{discount_id}','ProductController@discountDestroy')->name('discounts.destory');