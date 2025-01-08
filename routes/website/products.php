<?php

use Illuminate\Support\Facades\Route;

Route::get('products','ProductController@index');
Route::get('product/{link}','ProductController@show');


