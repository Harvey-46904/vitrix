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
    Route::post('editar_referidos_total_games/{id}','InversionesPaquete@UpdateNivelesGames')->name("UpdateNivelesGames");
    
    Route::get('rentabilidades/{id}','InversionesPaquete@rentabilidadesInversion')->name("RentabilidadesList");

    Route::get('rentabilidadesjuegos/{id}','InversionesPaquete@gamerentabilidad')->name("RentabilidadGame");
    Route::post('updaterentabilidad/{id}','InversionesPaquete@actualizarRentabilidad')->name("UpdateRentabilidad");
    Route::get('bonos_personal','ConfiguracionesController@indexbono')->name("IndexBonos");
    Route::get('feeds_configuracion','ConfiguracionesController@indexfeeds')->name("indexfeeds");
    
    Route::get('finanzas','ConfiguracionesController@finanzas')->name("IndexFinanzas");
    Route::get('pagarrentabilidad','InversionesPaquete@RentabilidadDiaria')->name("Rentabilidad");

    Route::get('pagares','CashController@pagare')->name("pagare");
    Route::get('recargas','CashController@recargas')->name("recargas");

    Route::get('apuestas/{id}','GamesController@ApuestasSeperadas')->name("apuestasunicas");
});

Route::post('generateinvoice','CashController@GenerateInvoice')->name("GenerateInvoice");

Route::post('updateinvoicestatus','CashController@UpdateInvoiceStatus')->name("UpdateInvoiceStatus");

Route::get('payforms/{action}/{hash}/{id?}','CashController@payforms')->name("payforms");
Route::post('webhookblockchain','CashController@PayBlockchains')->name("WebHookBlockchain");
Route::get('polygon/{transactionHash}','CashController@getTransactionEvents');

Route::get('listnave',"GamesController@ListNaves");
Route::get('roomi','GamesController@createRoom')->name("room");
Route::get('pruebitas',"GamesController@prueba_sala");


Route::get('/lang/{lang}', function ($lang) {
    session(['lang' => $lang]);
    app()->setLocale($lang);
    return redirect()->back();
})->name('lang.switch');

// Wave routes
Wave::routes();
