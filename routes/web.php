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


Route::post('/Ian_updateLocation','UserController@Ian_updateLocation');
Route::post('/calculateETATest','UserController@calculateETATest');
Route::post('/calculateETA','UserController@calculateETA');
Route::post('/viewETATable','UserController@viewETATable');
Route::post('/convertBustoptoNearestPolyLine','UserController@convertBustoptoNearestPolyLine');
Route::post('/getData','UserController@getData');
Route::post('/getKM','UserController@getKM');
Route::post('/testgetKM','UserController@testgetKM');
Route::post('/testCal','UserController@testCal');
Route::post('/getBusRoute','UserController@getBusRoute');
Route::post('/checkClosePointExist','UserController@checkClosePointExist');
Route::post('/calculateETAWin','UserController@calculateETAWin');
Route::post('/calculateHistoricDataAverage','UserController@calculateHistoricDataAverage');


Route::post('/calculateHistoricData','UserController@calculateHistoricData');
Route::post('/ianTest','UserController@ianTest');


Route::post('/pushCurrentData','UserController@pushCurrentData');
Route::post('/getETA','UserController@getETA');
Route::post('/getBusStopServices','UserController@getBusStopServices');

