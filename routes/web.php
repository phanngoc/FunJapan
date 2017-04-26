<?php

Route::get('/', function () {
    return view('web.home.index');
});

Route::get('/register/jmb_1', function (Request $request) {
    return view('web.users.register.jmb_1');
});
Route::get('/register/jmb_2', function (Request $request) {
    return view('web.users.register.jmb_2');
});

Route::group(['middleware' => 'locale', 'namespace' => 'Web'], function () {
    // Authentication Routes...
    Route::get('account/login', 'LoginController@showLoginForm')->name('login');
    Route::post('account/login', 'LoginController@login');

    Route::get('account/create', 'RegisterController@create')->name('register');
    Route::get('account/create/email', 'RegisterController@createStep2');
    Route::post('account/create/email', 'RegisterController@store');

    Route::get('account/confirm/{userId}/{socialId}/{provider}', 'RegisterController@createStep2ConfirmPass');
    Route::post('account/confirm', 'RegisterController@confirmPass');

    Route::get('account/create/success', 'RegisterController@createSuccess');
    Route::get('account/facebook', 'RegisterController@storeViaFaceBook');
    Route::get('facebook/callback', 'RegisterController@storeViaFaceBookCallBack')->name('facebook_callback');

    Route::get('/comments/lists/{articleId}', 'CommentsController@lists');
    Route::get('/comments/getEmoji', 'CommentsController@getEmoji');
    Route::get('/comments/getGif', 'CommentsController@getGif');
    Route::post('/articles/{id}/photo', 'ArticlePhotosController@store');
    Route::get('/articles/{id}/listsPhoto/{orderBy}', 'ArticlePhotosController@lists');

    Route::get('account/lost-password', 'ResetPasswordController@lostPassWord');
    Route::post('account/lost-password', 'ResetPasswordController@lostPassWordProcess');

    Route::get('account/reset-password/{token}', 'ResetPasswordController@resetPassword');
    Route::post('account/reset-password', 'ResetPasswordController@resetPasswordProcess');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('account/logout', 'LoginController@logout')->name('logout');

        Route::get('/comments/favorite/{userId}', 'CommentsController@favorite');
        Route::resource('comments', 'CommentsController');
    });

    Route::get('/articles/{id}', 'ArticlesController@show');
    Route::get('/articles/{id}/like', 'ArticlesController@countLike');
});
