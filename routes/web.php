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


Route::post('/Ian_updateLocation','userController@Ian_updateLocation');
Route::post('/calculateETATest','userController@calculateETATest');
Route::post('/calculateETA','userController@calculateETA');
Route::post('/viewETATable','userController@viewETATable');
Route::post('/convertBustoptoNearestPolyLine','userController@convertBustoptoNearestPolyLine');
Route::post('/getData','userController@getData');
Route::post('/getKM','userController@getKM');
Route::post('/testgetKM','userController@testgetKM');
Route::post('/testCal','userController@testCal');
Route::post('/getBusRoute','userController@getBusRoute');
Route::post('/checkClosePointExist','userController@checkClosePointExist');
Route::post('/calculateETAWin','userController@calculateETAWin');
Route::post('/calculateHistoricDataAverage','userController@calculateHistoricDataAverage');


Route::post('/calculateHistoricData','userController@calculateHistoricData');
Route::post('/ianTest','userController@ianTest');
Route::post('/getETA_schedule','userController@getETA_schedule');


Route::post('/pushCurrentData','userController@pushCurrentData');
Route::post('/getETA','userController@getETA');
Route::post('/getBusStopServices','userController@getBusStopServices');

