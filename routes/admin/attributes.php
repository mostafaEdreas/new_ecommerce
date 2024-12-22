<?php

use Illuminate\Support\Facades\Route;

Route::resource('attributes', 'AttributeController')->except(['show']);
Route::post('removeAttributeValue', 'AttributeController@removeAttributeValue')->name('removeAttributeValue');
Route::post('updateAttributeValue', 'AttributeController@updateAttributeValue')->name('updateAttributeValue');
Route::post('attributes/add-color/attribute', 'AttributeController@addColor')->name('add-color-attribute');


