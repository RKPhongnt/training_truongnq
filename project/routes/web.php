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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login')->middleware('guest');
Route::post('login', 'Auth\LoginController@login')->name('login')->middleware('guest');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('password/reset', 'Auth\ForgetPasswordController@showLinkRequestForm');
Route::prefix('admin')->group(function() {
    Route::get('/', 'AdminController@index');
});


Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
});
