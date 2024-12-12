<?php

use Illuminate\Support\Facades\Route;

  Route::get('shipping/fees','ShippingFeesController@index')->name('admin.shipping.fees.index');
  Route::PATCH('shipping/fees/update','ShippingFeesController@update')->name('admin.shipping.fees.update');