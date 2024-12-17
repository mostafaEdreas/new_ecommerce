<?php

use Illuminate\Support\Facades\Route;
Route::patch('/configrations/{configration}', 'ConfigrationController@update')->name('configrations.update');
Route::get('/configrations', 'ConfigrationController@index')->name('configrations.index');

Route::resource('/configrations', 'ConfigrationController');



