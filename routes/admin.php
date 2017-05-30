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

    Route::resource('popular-articles', 'PopularArticlesController');

    Route::resource('omikujis', 'OmikujisController');
    Route::get('getOmikujis', 'OmikujisController@getListOmikujis');
    Route::delete('/omikujis/delete/{id}', 'OmikujisController@destroyOmikuji');

    Route::resource('setting/popular-articles', 'PopularArticlesController');

    Route::get('setting/banner', 'BannerSettingsController@index');
    Route::post('setting/banner/{localeId}/locale', 'BannerSettingsController@update');
    Route::delete('setting/banner/{localeId}/locale', 'BannerSettingsController@delete');
    Route::get('setting/banner/get-article', 'BannerSettingsController@getArticle');

    Route::get('getCategories', 'CategoriesController@getCategories');

    Route::get('{action?}', 'DashboardController@index');

    Route::get('setting/ranks', 'ArticleRanksController@index');
    Route::get('setting/ranks/{locale}', 'ArticleRanksController@getArticleLocales');
    Route::post('setting/ranks/{locale}/store', 'ArticleRanksController@store');
    Route::post('setting/ranks/{locale}/delete', 'ArticleRanksController@destroy');
});