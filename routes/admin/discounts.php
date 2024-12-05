<?php

use Illuminate\Support\Facades\Route;

Route::get('discounts','DiscountController@index')->name('discounts.index');
Route::PATCH('discounts/{discount}','DiscountController@updata')->name('discounts.updata');
Route::post('discounts/','DiscountController@store')->name('discounts.store');