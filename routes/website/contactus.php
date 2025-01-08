<?php

use Illuminate\Support\Facades\Route;

Route::get('contact-us','ContactUsController@index');
Route::post('save/contact-us','ContactUsController@store');




