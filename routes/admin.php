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

    Route::resource('articles', 'ArticlesController');
    Route::get('articles/setOtherLanguage/{article}', 'ArticlesController@setOtherLanguage');
    Route::post('articles/updateOtherLanguage/{article}', 'ArticlesController@updateOtherLanguage');
    Route::get('getArticles', 'ArticlesController@getListArticles');

    Route::resource('tags', 'TagsController');
    Route::get('tagsSuggest', 'TagsController@suggest');
    Route::get('getTags', 'TagsController@getListTags');
    Route::put('tagBlock/{tag}', 'TagsController@block');

    Route::resource('categories', 'CategoriesController');
    Route::get('{action?}', 'DashboardController@index');

});