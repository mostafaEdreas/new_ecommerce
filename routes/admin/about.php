<?php

use Illuminate\Support\Facades\Route;

  Route::get('editAbout','AboutController@editAbout')->name('admin.editAbout');
  Route::PATCH('about/update','AboutController@update')->name('admin.about.update');