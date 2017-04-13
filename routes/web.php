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

//this is demo routes, when you use them, please edit them
Route::get('/', function () {
    return view('web.home.index');
});
Route::get('/articles/{id}', function () {
    return view('web.articles.show');
});
Route::get('/register/step_1', function (Request $request) {
    return view('web.users.register.step_1');
});
Route::get('/register/step_2', function (Request $request) {
    return view('web.users.register.step_2');
});
Route::get('/register/step_3', function (Request $request) {
    return view('web.users.register.step_3');
});
Route::get('/register/jmb_1', function (Request $request) {
    return view('web.users.register.jmb_1');
});
Route::get('/register/jmb_2', function (Request $request) {
    return view('web.users.register.jmb_2');
});
