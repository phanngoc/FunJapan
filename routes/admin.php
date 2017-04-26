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

    Route::get('recommend-articles/lists', 'RecommendedArticlesController@lists');
    Route::get('recommend-articles/recommendedLists', 'RecommendedArticlesController@recommendedLists');
    Route::resource('recommend-articles', 'RecommendedArticlesController');
    Route::resource('articles', 'ArticlesController');
    Route::get('articles/setOtherLanguage/{article}', 'ArticlesController@setOtherLanguage');
    Route::post('articles/updateOtherLanguage/{article}', 'ArticlesController@updateOtherLanguage');
    Route::get('getArticles', 'ArticlesController@getListArticles');
    Route::get('articles/edit-global/{article}', 'ArticlesController@editGlobalInfo');
    Route::post('articles/edit-global/{article}', 'ArticlesController@updateGlobalInfo');

    Route::resource('tags', 'TagsController');
    Route::get('tagsSuggest', 'TagsController@suggest');
    Route::get('getTags', 'TagsController@getListTags');
    Route::put('tagBlock/{tag}', 'TagsController@block');

    Route::resource('categories', 'CategoriesController');

    Route::resource('setting/popular-articles', 'PopularArticlesController');

    Route::get('setting/banner', 'BannerSettingsController@index');
    Route::post('setting/banner/{localeId}/locale', 'BannerSettingsController@update');
    Route::delete('setting/banner/{localeId}/locale', 'BannerSettingsController@delete');
    Route::get('setting/banner/get-article', 'BannerSettingsController@getArticle');

    Route::get('{action?}', 'DashboardController@index');

    Route::get('setting/ranks', 'ArticleRanksController@index');
    Route::get('setting/ranks/{locale}', 'ArticleRanksController@getArticleLocales');
    Route::post('setting/ranks/{locale}/store', 'ArticleRanksController@store');
    Route::post('setting/ranks/{locale}/delete', 'ArticleRanksController@destroy');
});