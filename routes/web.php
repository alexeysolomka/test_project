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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->middleware('havePermission')
    ->name('home');

$userConfig = [
    'prefix' => 'users',
    'middleware' => 'havePermission'
];

Route::group($userConfig, function () {
    Route::get('/create', 'UserController@create')->name('users.create');
    Route::post('/store', 'UserController@store')->name('users.store');
    Route::get('/{userId}/edit', 'UserController@edit')->name('users.edit');
    Route::post('/{userId}/update', 'UserController@update')->name('users.update');
    Route::post('delete/{userId}', 'UserController@destroy')->name('users.delete');
    Route::get('/avatar/delete/{userId}', 'UserController@removeAvatar')->name('users.avatar-delete');
});
