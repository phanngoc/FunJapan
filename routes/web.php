<?php

Route::get('/register/jmb_1', function (Request $request) {
    return view('web.users.register.jmb_1');
});
Route::get('/register/jmb_2', function (Request $request) {
    return view('web.users.register.jmb_2');
});

Route::group(['middleware' => 'locale', 'namespace' => 'Web'], function () {
    Route::get('/', 'HomesController@index')->name('index');
    Route::get('/errors', 'HomesController@error')->name('not_found');

    Route::group(['prefix' => 'guide'], function () {
        Route::get('/about', 'GuidesController@about');
        Route::get('/footprint', 'GuidesController@footPrint');
        Route::get('/staff', 'GuidesController@staff');
        Route::get('/previous-campaigns', 'GuidesController@previousCampaigns');
        Route::get('/faq', 'GuidesController@faq');
        Route::get('/contact-us', 'GuidesController@contactUs');
        Route::get('/privacy-policies', 'GuidesController@privacyPolicies');
        Route::get('/inquiry', 'GuidesController@inquiry');
        Route::get('/about-funjapan-points', 'GuidesController@aboutFunJapanPoints');
        Route::get('/terms-and-conditions', 'GuidesController@termsAndConditions');
        Route::get('/article-series', 'GuidesController@articleSeries');
    });

    // Authentication Routes...
    Route::get('account/login', 'LoginController@showLoginForm')->name('login');
    Route::post('account/login', 'LoginController@login');

    Route::get('account/create', 'RegisterController@create')->name('register');
    Route::get('account/create/email', 'RegisterController@createStep2');
    Route::post('account/create/email', 'RegisterController@store');

    Route::get('account/confirm/{userId}/{socialId}/{provider}', 'RegisterController@createStep2ConfirmPass');
    Route::post('account/confirm', 'RegisterController@confirmPass');

    Route::get('account/facebook', 'RegisterController@storeViaFaceBook');
    Route::get('facebook/callback', 'RegisterController@storeViaFaceBookCallBack')->name('facebook_callback');
    Route::post('account/create/jmb', 'RegisterController@storeJmb');
    Route::group(['middleware' => 'auth'], function () {
        Route::get('account/create/success', 'RegisterController@createSuccess');
        Route::get('account/create/final', 'RegisterController@finalStep');
        Route::get('/myfeed', 'HomesController@getMyFeed');
    });

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
        Route::get('account/invite-friends', 'InviteFriendsController@index');
        Route::get('/comments/favorite/{userId}', 'CommentsController@favorite');
        Route::resource('comments', 'CommentsController');

        Route::get('/photo/{id}/favorite', 'ArticlePhotosController@favorite');

        Route::get('Account/BasicProfile', 'UsersController@index')->name('profile');
        Route::post('Account/BasicProfile', 'UsersController@update');
        Route::get('Account/Interest', 'UsersController@interest')->name('interest');
        Route::post('Account/Interest', 'UsersController@updateInterest');

        Route::get('Account/ChangePassword', 'UsersController@password')->name('change_password');
        Route::post('Account/ChangePassword', 'UsersController@updatePassword');

        Route::get('/Account/Close', 'UsersController@close')->name('close_account');
        Route::post('/Account/Close', 'UsersController@closeAccount');

        Route::get('notifications/list', 'NotificationsController@list');
        Route::get('notifications/dismiss', 'NotificationsController@dismiss');

        Route::get('Account/Omikuji', 'OmikujisController@index');
        Route::post('Account/Omikuji', 'OmikujisController@create');

    });

    Route::get('/Account/CloseComplete', 'UsersController@closeComplete')->name('close_complete');

    Route::get('/articles/{id}', 'ArticlesController@show')->name('article_detail');
    Route::get('/articles/{id}/like', 'ArticlesController@countLike');
    Route::get('/articles/{id}/share', 'ArticlesController@countShare');

    Route::get('/tag/{name}', 'TagsController@show')->name('tag_detail');
    Route::get('/category/{name}', 'CategoriesController@show')->name('category_detail');
});
