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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return auth()->user();
});

Route::middleware('auth:api')->post('/play-genius', "GamesController@GeniusPlayGame")->name("PlayGenius");
Route::middleware('auth:api')->post('/play-genius-salva', "GamesController@ApuestaSalvaGame")->name("PlayGeniusSalva");
Route::middleware('auth:api')->post('roomi','GamesController@createRoom')->name("room");
Route::middleware('auth:api')->post('/play-naves','GamesController@CompetenciaNave')->name("RegistroNave");

Wave::api();
