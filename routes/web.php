<?php

Route::get('/', 'FrontEndController@index')->name('front');
Route::get('/'.env('URL_ROUTE','restaurant').'/{alias}', 'FrontEndController@restorant')->name('vendor');

Route::post('/search/location', 'FrontEndController@getCurrentLocation')->name('search.location');

Auth::routes(['register' => !config('app.isqrsaas')]);

Route::get('/home', 'HomeController@index')->name('home');

