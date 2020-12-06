<?php

Route::get('/', 'FrontEndController@index')->name('front');
Route::get('/'.env('URL_ROUTE','restaurant').'/{alias}', 'FrontEndController@restorant')->name('vendor');

Route::post('/search/location', 'FrontEndController@getCurrentLocation')->name('search.location');

Auth::routes(['register' => !config('app.isqrsaas')]);

Route::get('/home', 'HomeController@index')->name('home');


//Route::group(['middleware' => 'auth'], function () {
Route::group(['middleware' => ['auth']], function () {
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::post('/user/push', 'UserController@checkPushNotificationId');

    Route::name('admin.')->group(function () {
        Route::resource('restaurants', 'RestorantController');
    });

    Route::get('/restaurant/{restorant}/activate', 'RestorantController@activateRestaurant')->name('restaurant.activate');
    Route::post('/restaurant/workinghours', 'RestorantController@workingHours')->name('restaurant.workinghours');


    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::resource('items', 'ItemsController');
    Route::prefix('items')->name('items.')->group(function () {
        Route::get('list/{restorant}', 'ItemsController@indexAdmin')->name('admin');

    });


    Route::post('/item/change/{item}', 'ItemsController@change');

    Route::resource('categories', 'CategoriesController');

    Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');

    Route::get('qr','QRController@index')->name('qr');
});

Route::get('/new/restaurant/register', 'RestorantController@showRegisterRestaurant')->name('newrestaurant.register');
Route::post('/new/restaurant/register/store', 'RestorantController@storeRegisterRestaurant')->name('newrestaurant.store');

Route::get('/get/rlocation/{restorant}', 'RestorantController@getLocation');


Route::post('/feedback/{restaurant}', 'RestorantController@feedback');
Route::get('/feedbacks', 'FeedbackController@index')->name('feedbacks');
