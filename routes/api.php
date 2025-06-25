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
//genius
Route::middleware('auth:api')->post('/play-genius', "GamesController@GeniusPlayGame")->name("PlayGenius");
Route::middleware('auth:api')->post('/play-genius-salva', "GamesController@ApuestaSalvaGame")->name("PlayGeniusSalva");

//nave
Route::middleware('auth:api')->post('/play-naves', "GamesController@NavesPlayGame")->name("PlayNaves");

Route::middleware('auth:api')->post('/play-naves-salva','GamesController@CompetenciaNave')->name("RegistroNave");
//cars
Route::middleware('auth:api')->post('/play-cars', "GamesController@CarsFinishGame")->name("PlayCars");

Route::middleware('auth:api')->get('roomi','GamesController@createRoom')->name("room");


Route::middleware('auth:api')->post('/eventsala/{id_sala}','GamesController@eventsala')->name("eventsala");



Route::get('roomi','GamesController@createRoom')->name("room");
Wave::api();
