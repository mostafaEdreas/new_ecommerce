<?php

use Illuminate\Support\Facades\Route;

Route::resource('/products', 'ProductController');
Route::get('products/{product}/images' , 'ProductController@images')->name('products.images.index') ;
Route::post('products/{product}/images/upload' , 'ProductController@uploadImages')->name('products.images.upload') ;
Route::delete('products/{product}/images/remove' , 'ProductController@removeImages')->name('products.images.remove') ;