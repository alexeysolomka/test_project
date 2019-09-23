<?php

$crudUserConfig = [
    'namespace' => 'Api',
    'middleware' => 'havePermission'
];

Route::post('/login', 'Api\LoginController@login')->name('api.login');
Route::post('/logout', 'Api\LoginController@logout')->name('api.logout');

Route::post('users/{limit?}/{offset?}', 'Api\UserController@index')->middleware('havePermission');
Route::post('/show/{userId}', 'Api\UserController@show')->middleware('havePermission');
Route::post('/profile', 'Api\UserController@profile')->middleware('havePermission');
Route::post('/store', 'Api\UserController@store')->middleware('havePermission');
Route::post('/update/{userId}', 'Api\UserController@update')->middleware('havePermission');
Route::post('/delete/{userId}', 'Api\UserController@destroy')->middleware('havePermission');
