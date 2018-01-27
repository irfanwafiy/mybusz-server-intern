<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



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
Route::post('/simulator_insertlocation','userController@simulator_insertlocation');


Route::post('/pushCurrentData','userController@pushCurrentData');
Route::post('/getETA','userController@getETA');
Route::post('/getBusStopServices','userController@getBusStopServices');

