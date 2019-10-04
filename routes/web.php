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


Route::get('/map', function () {
    return view('underground.test_map');
});

Auth::routes();
Route::match(['post', 'get'], 'register', function () {
    Auth::logout();
    return redirect('/');
})->name('register');
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
    $metroConfig = [
        'prefix' => 'metros'
    ];
    Route::group($metroConfig, function () {
        Route::get('/', 'MetroController@index')->name('metros.index');
        Route::get('/create', 'MetroController@create')->name('metros.create');
        Route::post('/store', 'MetroController@store')->name('metros.store');
        Route::get('/edit/{metro_id}', 'MetroController@edit')->name('metros.edit');
        Route::post('/update/{metro_id}', 'MetroController@update')->name('metros.update');
        Route::post('/delete/{metro_id}', 'MetroController@delete')->name('metros.delete');
    });

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

    $intersectionConfig = [
        'prefix' => 'intersections'
    ];
    Route::group($intersectionConfig, function () {
        Route::get('/', 'IntersectionController@index')->name('intersections.index');
        Route::post('/add-station-to-intersection/{intersection_id}', 'IntersectionController@addStationToIntersection')->name('intersections.add_station');
        Route::post('/delete-station-to-intersection/{intersection_id}/{station_id}', 'IntersectionController@deleteStationFromIntersection')->name('intersections.delete-station');
        Route::get('/create', 'IntersectionController@create')->name('intersections.create');
        Route::post('/store', 'IntersectionController@store')->name('intersections.store');
        Route::get('/edit/{intersection_id}', 'IntersectionController@edit')->name('intersections.edit');
        Route::post('/update/{intersection_id}', 'IntersectionController@update')->name('intersections.update');
        Route::post('/delete/{intersection_id}', 'IntersectionController@delete')->name('intersections.delete');
    });
});

$searchPathConfig = [
    'prefix' => 'search-path/'
];
Route::group($searchPathConfig, function () {
    Route::get('/index', 'SearchShortPathController@index')->name('underground.searchIndex');
    Route::get('/get-stations', 'SearchShortPathController@getStations')->name('underground.getStations');
    Route::post('/search-stations', 'SearchShortPathController@searchStations')->name('underground.searchStations');
    Route::post('/search', 'SearchShortPathController@search')->name('underground.search');
});
