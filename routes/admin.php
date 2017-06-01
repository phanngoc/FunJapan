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
        Route::resource('articles', 'ArticlesController');
        Route::get('articles/setOtherLanguage/{article}', 'ArticlesController@setOtherLanguage');
        Route::post('articles/updateOtherLanguage/{article}', 'ArticlesController@updateOtherLanguage');
        Route::get('getArticles', 'ArticlesController@getListArticles');
        Route::get('articles/edit-global/{article}', 'ArticlesController@editGlobalInfo');
        Route::post('articles/edit-global/{article}', 'ArticlesController@updateGlobalInfo');
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

        Route::get('popular-list', 'PopularArticlesController@popularLists');
        Route::get('popular-articles/list', 'PopularArticlesController@lists');
        Route::resource('popular-articles', 'PopularArticlesController');
        Route::resource('surveys', 'SurveysController');

        Route::resource('surveys.questions', 'QuestionsController');
        Route::post('questions/updateOrder', 'QuestionsController@updateOrder');

        Route::resource('surveys.results', 'ResultsController');

        Route::resource('omikujis', 'OmikujisController');
        Route::get('getOmikujis', 'OmikujisController@getListOmikujis');
        Route::delete('/omikujis/delete/{id}', 'OmikujisController@destroyOmikuji');

        Route::get('setting/banner', 'BannerSettingsController@index');
        Route::post('setting/banner/{localeId}/locale', 'BannerSettingsController@update');
        Route::delete('setting/banner/{localeId}/locale', 'BannerSettingsController@delete');
        Route::get('setting/banner/get-article', 'BannerSettingsController@getArticle');

        Route::get('getCategories', 'CategoriesController@getCategories');

        Route::get('popular-series', 'PopularSeriesController@index');
        Route::get('popular-series/create', 'PopularSeriesController@create');
        Route::post('popular-series/store', 'PopularSeriesController@store');
        Route::get('popular-series/edit/{popularSeries}', 'PopularSeriesController@edit');
        Route::post('popular-series/update/{popularSeries}', 'PopularSeriesController@update');
        Route::post('popular-series/delete/{popularSeries}', 'PopularSeriesController@delete');
        Route::get('popular-series/getSuggest', 'PopularSeriesController@getSuggest');
        Route::get('popular-series/getListSeries', 'PopularSeriesController@getListSeries');

        Route::resource('coupons', 'CouponsController');
        Route::get('list-coupon', 'CouponsController@getListCoupons');

        Route::get('popular-category', 'PopularCategoriesController@index');
        Route::get('popular-category/create', 'PopularCategoriesController@create');
        Route::post('popular-category/store', 'PopularCategoriesController@store');
        Route::get('popular-category/edit/{popularCategory}', 'PopularCategoriesController@edit');
        Route::post('popular-category/update/{popularCategory}', 'PopularCategoriesController@update');
        Route::post('popular-category/delete/{popularCategory}', 'PopularCategoriesController@delete');
        Route::get('popular-category/getSuggest', 'PopularCategoriesController@getSuggest');
        Route::get('popular-category/getListCategories', 'PopularCategoriesController@getListCategories');

        Route::get('roles/users', 'RolesController@getUsersRole');
        Route::post('roles/users', 'RolesController@postUsersRole');
        Route::get('roles/{role}/change-permission', 'RolesController@getChangePermission');
        Route::post('roles/{role}/change-permission', 'RolesController@postChangePermission');
        Route::resource('roles', 'RolesController');

        Route::get('{action?}', 'DashboardController@index');

        Route::get('setting/ranks', 'ArticleRanksController@index');
        Route::get('setting/ranks/{locale}', 'ArticleRanksController@getArticleLocales');
        Route::post('setting/ranks/{locale}/store', 'ArticleRanksController@store');
        Route::post('setting/ranks/{locale}/delete', 'ArticleRanksController@destroy');
    });
});
