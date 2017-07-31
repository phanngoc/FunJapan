<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'Admin'], function () {
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');

    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::get('recommend-articles/lists', 'RecommendedArticlesController@lists');
        Route::get('recommend-articles/recommendedLists', 'RecommendedArticlesController@recommendedLists');
        Route::resource('recommend-articles', 'RecommendedArticlesController');
        Route::get('articles/stop', 'ArticlesController@stop');
        Route::get('articles/stopOrStart', 'ArticlesController@stopOrStart');
        Route::get('articles/always-on-top', 'ArticlesController@alwaysOnTop');
        Route::post('articles/always-on-top', 'ArticlesController@setAlwaysOnTop');
        Route::delete('articles/always-on-top/{articleLocaleId}', 'ArticlesController@deleteAlwaysOnTop');
        Route::post('articles/preview', 'ArticlesController@preview');
        Route::post('articles/validate', 'ArticlesController@validateInput');
        Route::post('articles/confirm', 'ArticlesController@confirm');
        Route::post('articles/cancelConfirm', 'ArticlesController@cancelConfirm');
        Route::post('articles/upload-image', 'ArticlesController@uploadImage');
        Route::post('articles/delete-image', 'ArticlesController@deleteImage');
        Route::resource('articles', 'ArticlesController');
        Route::get('getArticles', 'ArticlesController@getListArticles');

        Route::get('getCategoryLocale', 'ArticlesController@getCategoryLocale');

        Route::resource('article-comments', 'ArticleCommentsController');
        Route::get('getArticleComments', 'ArticleCommentsController@getListArticleComments');

        Route::resource('tags', 'TagsController');
        Route::get('tagsSuggest', 'TagsController@suggest');
        Route::get('getTags', 'TagsController@getListTags');
        Route::post('tagBlock/{tag}', 'TagsController@block');

        Route::get('showHotTags', 'TagsController@showHotTags');
        Route::get('settingHotTags', 'TagsController@settingHotTags');
        Route::post('updateHotTag', 'TagsController@updateHotTag');

         Route::get('menus/getCategories', 'MenusController@getCategories');
         Route::resource('menus', 'MenusController');
         Route::get('menus/createSubMenu/{menu}', 'MenusController@createSubMenu');
         Route::post('menus/createSubMenu/{menu}', 'MenusController@storeSubMenu');
         Route::get('menus/editSubMenu/{menu}', 'MenusController@editSubMenu');
         Route::put('menus/updateSubMenu/{menu}', 'MenusController@updateSubMenu');
         Route::post('menus/updateOrder', 'MenusController@updateOrder');
         Route::get('menus/showSubMenu/{menu}', 'MenusController@showSubMenu');
         Route::get('menus/setOtherLanguage/{menu}', 'MenusController@setLanguageSubMenu');
         Route::post('menus/storeOtherLanguage/{menu}', 'MenusController@storeLanguageSubMenu');

        Route::resource('categories', 'CategoriesController');

        // Route::get('popular-list', 'PopularArticlesController@popularLists');
        // Route::get('popular-articles/list', 'PopularArticlesController@lists');
        // Route::resource('popular-articles', 'PopularArticlesController');

        Route::resource('omikujis', 'OmikujisController');
        Route::get('getOmikujis', 'OmikujisController@getListOmikujis');
        Route::delete('/omikujis/delete/{id}', 'OmikujisController@destroyOmikuji');

        Route::get('setting/banner', 'BannerSettingsController@index');
        Route::post('setting/banner', 'BannerSettingsController@store');
        //Route::delete('setting/banner/{bannerId}', 'BannerSettingsController@delete');
        Route::get('setting/banner/get-article', 'BannerSettingsController@getArticle');
        Route::post('setting/banner/{bannerId}', 'BannerSettingsController@update');

        Route::get('getCategories', 'CategoriesController@getCategories');

        // Route::get('popular-series', 'PopularSeriesController@index');
        // Route::get('popular-series/create', 'PopularSeriesController@create');
        // Route::post('popular-series/store', 'PopularSeriesController@store');
        // Route::get('popular-series/edit/{popularSeries}', 'PopularSeriesController@edit');
        // Route::post('popular-series/update/{popularSeries}', 'PopularSeriesController@update');
        // Route::post('popular-series/delete/{popularSeries}', 'PopularSeriesController@delete');
        // Route::get('popular-series/getSuggest', 'PopularSeriesController@getSuggest');
        // Route::get('popular-series/getListSeries', 'PopularSeriesController@getListSeries');


        // Route::get('popular-category', 'PopularCategoriesController@index');
        // Route::get('popular-category/create', 'PopularCategoriesController@create');
        // Route::post('popular-category/store', 'PopularCategoriesController@store');
        // Route::get('popular-category/edit/{popularCategory}', 'PopularCategoriesController@edit');
        // Route::post('popular-category/update/{popularCategory}', 'PopularCategoriesController@update');
        // Route::post('popular-category/delete/{popularCategory}', 'PopularCategoriesController@delete');
        // Route::get('popular-category/getSuggest', 'PopularCategoriesController@getSuggest');
        // Route::get('popular-category/getListCategories', 'PopularCategoriesController@getListCategories');

        Route::get('roles/users', 'RolesController@getUsersRole');
        Route::post('roles/users', 'RolesController@postUsersRole');
        Route::get('roles/{role}/change-permission', 'RolesController@getChangePermission');
        Route::post('roles/{role}/change-permission', 'RolesController@postChangePermission');
        Route::resource('roles', 'RolesController');
        Route::get('ids', 'IdsController@index');
        Route::resource('clients', 'ClientsController');
        Route::post('authors/{authorId}', 'AuthorsController@update');
        Route::resource('authors', 'AuthorsController');

        Route::get('editor-choices', 'EditorChoicesController@index');
        Route::post('editor-choices/store', 'EditorChoicesController@store');
        Route::post('editor-choices/update', 'EditorChoicesController@update');
        Route::post('editor-choices/destroy', 'EditorChoicesController@destroy');

        Route::get('{action?}', 'DashboardController@index');

        // Route::get('setting/ranks', 'ArticleRanksController@index');
        // Route::get('setting/ranks/{locale}', 'ArticleRanksController@getArticleLocales');
        // Route::post('setting/ranks/{locale}/store', 'ArticleRanksController@store');
        // Route::post('setting/ranks/{locale}/delete', 'ArticleRanksController@destroy');

        Route::get('setting/api-token-list', 'ApiTokenController@index');
        Route::get('setting/api-token/list', 'ApiTokenController@lists');
        Route::post('setting/api-token', 'ApiTokenController@store');
        Route::get('setting/api-token/delete/{id}', 'ApiTokenController@destroy');
        Route::get('setting/api-token/get-user', 'ApiTokenController@getUser');

        Route::get('setting/advertisements', 'AdvertisementsController@index');
        Route::post('setting/advertisements', 'AdvertisementsController@update');
        Route::post('setting/advertisements/change/{advertisementId}', 'AdvertisementsController@change');
    });
});
