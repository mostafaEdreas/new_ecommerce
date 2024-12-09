<?php

use Illuminate\Support\Facades\Route;

Route::resource('/products', 'ProductController');
Route::get('images/{product}/products' , 'ProductController@getImages')->name('products.images.index') ;
Route::post('images/{product}/products/upload' , 'ProductController@uploadImages')->name('products.images.upload') ;
Route::delete('images/{product}/products/remove' , 'ProductController@removeImages')->name('products.images.remove') ;
Route::get('attributes/{product}/products/value' , 'ProductController@getAttributes')->name('products.attributes.index') ;
Route::get('attributes/ajax/products/get-values' , 'ProductController@getValues')->name('products.ajax.getValues');
Route::post('attributes/{product}/products/value' , 'ProductController@storeValuesToAttributes')->name('products.attributes.value.store') ;
Route::post('stocks/{product}/products' , 'ProductController@storeStock')->name('products.stocks.store') ;
Route::get('stocks/{product}/products' , 'ProductController@getStocks')->name('products.stocks.index') ;
Route::patch('stocks/{stock}/products' , 'ProductController@updateStock')->name('products.stocks.update') ;
Route::delete('stocks/{stock}' , 'ProductController@destoryStock')->name('products.stocks.delete') ;
