<?php

use Illuminate\Support\Facades\Route;
Route::patch('/settings/{setting}', 'SettingController@update')->name('settings.update');
Route::get('/settings', 'SettingController@index')->name('settings.index');


