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
Route::get('/2fa', 'TwoFactorController@showForm');
Route::post('/2fa', 'TwoFactorController@verifyTwoFactor')->middleware('auth');

Route::get('/home', 'HomeController@index')
    ->middleware(['2fa', 'havePermission'])
    ->name('home');

$userConfig = [
    'prefix' => 'users',
    'middleware' => ['2fa', 'havePermission']
];

Route::group($userConfig, function () {
    Route::get('/create', 'UserController@create')->name('users.create');
    Route::post('/store', 'UserController@store')->name('users.store');
    Route::get('/{userId}/edit', 'UserController@edit')->name('users.edit');
    Route::get('/{userId}/profile', 'UserController@profile')->name('users.profile');
    Route::post('/{userId}/update', 'UserController@update')->name('users.update')->middleware('canModerator');
    Route::post('delete/{userId}', 'UserController@destroy')->name('users.delete');
    Route::get('/avatar/delete/{userId}', 'UserController@removeAvatar')->name('users.avatar-delete');
});


$undegroundConfig = [
    'prefix' => 'underground',
    'middleware' => ['2fa', 'havePermission']
];
Route::group($undegroundConfig, function () {
    $staionConfig = [
        'prefix' => 'stations'
    ];
    Route::group($staionConfig, function () {
        Route::get('/', 'StationController@index')->name('stations.index');
        Route::get('/create', 'StationController@create')->name('stations.create');
        Route::post('/store', 'StationController@store')->name('stations.store');
        Route::get('/edit/{station_id}', 'StationController@edit')->name('stations.edit');
        Route::post('/update/{station_id}', 'StationController@update')->name('stations.update');
        Route::post('/delete/{station_id}', 'StationController@delete')->name('stations.delete');
    });

    $branchConfig = [
        'prefix' => 'branches'
    ];
    Route::group($branchConfig, function () {
        Route::get('/', 'BranchController@index')->name('branches.index');
        Route::get('/create', 'BranchController@create')->name('branches.create');
        Route::post('/store', 'BranchController@store')->name('branches.store');
        Route::get('/edit/{station_id}', 'BranchController@edit')->name('branches.edit');
        Route::post('/update/{station_id}', 'BranchController@update')->name('branches.update');
        Route::post('/delete/{station_id}', 'BranchController@delete')->name('branches.delete');
     });

    Route::get('/search_path_form', 'SearchShortPathController@index')->name('underground.searchIndex');
    Route::post('/search', 'SearchShortPathController@search')->name('underground.search');
});
