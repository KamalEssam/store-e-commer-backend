<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api', 'namespace' => 'Api'], function () {
    Route::post('profile/edit', 'AuthController@editProfile');
    Route::post('password/change', 'AuthController@changePassword');

    // create order
    Route::post('order/create', 'HomeController@createOrder');

    // get list of notifications
    Route::post('notification-list', 'NotificationController@getNotifications');
    Route::post('notification/read', 'NotificationController@setRead');  // set notification as read
    Route::post('notification/count', 'NotificationController@getUnreadNotificationsCount');

    Route::post('address/add', 'AddressController@addAddress');
    Route::post('address/remove', 'AddressController@removeAddress');
    Route::post('address/get', 'AddressController@getAddresses');
    Route::post('address/set-default', 'AddressController@setDefaultAddress');

    // tokens
    Route::post('/set-token', ['uses' => 'TokenController@setToken', 'as' => 'token.set']);
    Route::post('/logout', ['uses' => 'TokenController@removeToken', 'as' => 'token.remove']);
});


Route::group(['namespace' => 'Api'], function () {
    Route::get('home/categories', 'HomeController@categories');
    Route::post('home/products', 'HomeController@products');
    Route::post('home/product/details', 'HomeController@productDetails');
    Route::post('signup', 'AuthController@signUp');
    Route::post('login', 'AuthController@login');
    Route::get('about_us', 'SettingController@about_us');

    Route::post('notifications/switch', 'AuthController@switchNotification');
    Route::post('forgot-password', 'AuthController@forgetPassword');
});

Route::get('ads', 'Web\AdsController@getAdsApi');

