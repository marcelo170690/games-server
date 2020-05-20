<?php

use Illuminate\Http\Request;

Route::apiResource('game', 'GameController');
Route::apiResource('user', 'UserController');
Route::apiResource('match', 'MatchController');
Route::apiResource('msg', 'MsgController');

//charts
Route::get('chart/scoreUser', 'ChartController@scoreUser');
Route::get('chart/gamePopular', 'ChartController@gamePopular');
Route::get('chart/gameScore', 'ChartController@gameScore');

//auth
Route::post('login', 'AuthController@login');
Route::middleware('auth:api')->post('logout', 'AuthController@logout');
Route::middleware('auth:api')->get('auth', 'AuthController@auth');
