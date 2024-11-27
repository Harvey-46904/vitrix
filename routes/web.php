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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;
use Wave\Facades\Wave;

// Authentication routes
Auth::routes();

// Voyager Admin routes
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
    Route::get('referidos','ConfiguracionesController@IndexNiveles')->name("IndexNiveles");
    Route::get('editar_referidos','ConfiguracionesController@EditNiveles')->name("EditNiveles");
    Route::post('editar_referidos_total','ConfiguracionesController@UpdateNiveles')->name("UpdateNiveles");

    Route::get('rentabilidades/{id}','InversionesPaquete@rentabilidadesInversion')->name("RentabilidadesList");
    Route::post('updaterentabilidad/{id}','InversionesPaquete@actualizarRentabilidad')->name("UpdateRentabilidad");
    Route::get('bonos_personal','ConfiguracionesController@indexbono')->name("IndexBonos");
    Route::get('finanzas','ConfiguracionesController@finanzas')->name("IndexFinanzas");
    Route::get('pagarrentabilidad','InversionesPaquete@RentabilidadDiaria')->name("Rentabilidad");
});

Route::get('pruebitas',function(){
    event (new \App\Events\CashMoneyEvent());
    return response(["data"=>"hijitos"]);
});

// Wave routes
Wave::routes();
