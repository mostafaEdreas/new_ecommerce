<?php

use Illuminate\Support\Facades\Route;

Route::resource('users', 'UserController');
Route::get('user-admins', 'UserController@admins');