<?php

$crudUserConfig = [
    'namespace' => 'Api',
    'middleware' => 'havePermission'
];

Route::post('/login', 'Api\LoginController@login')->name('api.login');
Route::post('/logout', 'Api\LoginController@logout')->name('api.logout');

Route::group($crudUserConfig, function () {
    Route::get('users', 'UserController@index');
    Route::get('/users/{userId}', 'UserController@show');
    Route::post('/users', 'UserController@store');
    Route::put('/users/{userId}', 'UserController@update')->middleware('canModerator');
    Route::delete('/users/{userId}', 'UserController@destroy')->middleware('canModerator');

    Route::get('/profile', 'UserController@profile');
    Route::put('/profile', 'UserController@updateProfile');
});

