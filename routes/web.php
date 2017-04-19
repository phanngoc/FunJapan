<?php

Route::get('/', function () {
    return view('web.home.index');
});

Route::group(['middleware' => ['web'], 'namespace' => 'Web'], function () {
});

Route::get('/register/jmb_1', function (Request $request) {
    return view('web.users.register.jmb_1');
});
Route::get('/register/jmb_2', function (Request $request) {
    return view('web.users.register.jmb_2');
});

Route::group(['middleware' => 'web', 'namespace' => 'Web'], function () {
    // Authentication Routes...
    Route::get('account/login', 'LoginController@showLoginForm')->name('login');
    Route::post('account/login', 'LoginController@login');
//    Route::get('account/logout', 'LoginController@logout')->name('logout');

//    // Password Reset Routes...
//    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('account/create', 'RegisterController@create');
    Route::get('account/create/email', 'RegisterController@createStep2');
    Route::post('account/create/email', 'RegisterController@store');

    //
    Route::get('account/confirm/{userId}/{socialId}/{provider}', 'RegisterController@createStep2ConfirmPass');
    Route::post('account/confirm', 'RegisterController@confirmPass');

    Route::get('account/create/success', 'RegisterController@createSuccess');
    Route::get('account/facebook', 'RegisterController@storeViaFaceBook');
    Route::get('facebook/callback', 'RegisterController@storeViaFaceBookCallBack');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('account/logout', 'LoginController@logout')->name('logout');
    });

    Route::get('/articles/{id}', 'ArticlesController@show');
});
