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

Auth::routes();

Route::get('/', 'Auth\LoginController@showLoginForm')->name('home');


Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');



Route::prefix('admin')->group(function() {
    Route::get('/', 'Admin\AdminController@index');
    Route::get('new_user', 'Admin\UserManagerController@showNewUserForm');
    Route::post('new_user', 'Admin\UserManagerController@newUser')->name('admin.users.new');
    Route::get('users', 'Admin\UserManagerController@showListUser')->name('admin.users');
    Route::get('users/{id}/edit', 'Admin\UserManagerController@editUser')->name('admin.users.edit');
    Route::post('users/{id}/update', 'Admin\UserManagerController@updateUser')->name('admin.users.update');
    Route::get('users/{id}/destroy', 'Admin\UserManagerController@destroyUser')->name('admin.users.destroy');

    Route::get('divisions/new', 'Admin\DivisionManagerController@showNewDivisionForm');
    Route::post('divisions/new', 'Admin\DivisionManagerController@newDivision')->name('admin.divisions.new');

    Route::get('divisions', 'Admin\DivisionManagerController@showListDivision')->name('admin.divisions');
    Route::get('divisions/{id}/edit', 'Admin\DivisionManagerController@edit')->name('admin.divisions.edit');
    Route::post('divisions/{id}/update', 'Admin\DivisionManagerController@update')->name('admin.divisions.update');
});


Route::prefix('user')->group(function() {
    Route::get('/', 'UserController@index');
});
