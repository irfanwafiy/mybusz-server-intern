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

Route::get('/getBusRoute/{route_id}', 'getBusInfoController@getBusRoute');
Route::get('/getBusRouteInfo', 'getBusInfoController@getBusRouteInfo');
Route::get('/getBusService', 'getBusInfoController@getBusService');
Route::get('/getBusStop', 'getBusInfoController@getBusStop');
Route::get('/getBusstopRoute', 'getBusInfoController@getBusstopRoute');
Route::get('/getLocationData', 'getBusInfoController@getLocationData');
Route::get('/getNearbyBusStop', 'getBusInfoController@getNearbyBusStop');
Route::get('/getBusstopList', 'getBusInfoController@getBusstopList');
Route::get('/getETA', 'getBusInfoController@getETA');
Route::get('/updateLocation', 'getBusInfoController@updateLocation');




