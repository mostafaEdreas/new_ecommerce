<?php

use Illuminate\Support\Facades\Route;

Route::get('contact-us-messages', 'ContactusController@index')->name('contact-us-messages.index');
Route::get('contact-us-messages/{message}', 'ContactusController@show')->name('contact-us-messages.show');
Route::delete('contact-us-messages/{message}', 'ContactusController@destroy')->name('contact-us-messages.destroy');


