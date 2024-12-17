<?php

use Illuminate\Support\Facades\Route;

Route::resource('attributes', 'AttributeController');
Route::post('removeAttributeValue', 'AttributeController@removeAttributeValue')->name('removeAttributeValue');
Route::post('updateAttributeValue', 'AttributeController@updateAttributeValue')->name('updateAttributeValue');

