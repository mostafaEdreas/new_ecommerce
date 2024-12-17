<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@admin');
Route::get('switch-theme', 'AdminController@switchTheme');
Route::get('translations', 'AdminController@translations');
Route::post('{name}/up/{ids}','AdminController@updatestatus');
