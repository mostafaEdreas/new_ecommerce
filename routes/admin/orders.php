<?php

use Illuminate\Support\Facades\Route;

Route::resource('orders', 'OrderController');
Route::post('orders/changeStatus', 'OrderController@changeOrderStatus');
Route::post('orders/changeOrderPaymentStatus', 'OrderController@changeOrderPaymentStatus')->name('changeOrderPaymentStatus');
Route::get('order/{id}/invoice', 'OrderController@orderInvoice');
Route::post('order/{id}/cancel', 'OrderController@orderCancel');
Route::post('orders/filter', 'OrderController@orderFilter');
Route::post('order/delivery/{id}', 'OrderController@OrderDelivey');