<?php

use Illuminate\Support\Facades\Route;

Route::get('seo-assistant','SeoAssistantContoller@index')->name('admin.seo-assistant.index');
Route::PATCH('seo-assistant/','SeoAssistantContoller@update')->name('admin.seo-assistant.update');