<?php

use Illuminate\Support\Facades\Route;

Route::impersonate();

//enlaces
Route::view('casino', 'theme::Accesorios.casino')->name('casino');
Route::view('inversion', 'theme::Accesorios.inversion')->name('inversion');
Route::view('referidos', 'theme::Accesorios.referidos')->name('referidos_informacion');

Route::view('historia', 'theme::Accesorios.historia')->name('historia');
Route::view('compañia', 'theme::Accesorios.compañia')->name('compañia');

Route::view('ayuda', 'theme::Accesorios.ayuda')->name('ayuda');
Route::view('noticias', 'theme::Accesorios.noticias')->name('noticias');
Route::view('sitemap', 'theme::Accesorios.sitemap')->name('sitemap');
Route::view('preguntas', 'theme::Accesorios.preguntas')->name('preguntas');
Route::view('contactanos', 'theme::Accesorios.contactanos')->name('contactanos');

Route::view('novedades', 'theme::Accesorios.novedades')->name('novedades');
Route::view('patrocinadores', 'theme::Accesorios.patrocinadores')->name('patrocinadores');
Route::view('correo', 'theme::Accesorios.correo')->name('correo');

Route::view('privacidad', 'theme::Accesorios.privacidad')->name('privacidad');
Route::view('renuncias', 'theme::Accesorios.renuncias')->name('renuncias');
Route::view('terminos', 'theme::Accesorios.terminos')->name('terminos');
//otrs
Route::get('/', '\Wave\Http\Controllers\HomeController@index')->name('wave.home');
Route::get('@{username}', '\Wave\Http\Controllers\ProfileController@index')->name('wave.profile');

// Documentation routes
Route::view('docs/{page?}', 'docs::index')->where('page', '(.*)');
Route::get('register/{referido}', '\Wave\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register_ref');
// Additional Auth Routes
Route::get('logout', '\Wave\Http\Controllers\Auth\LoginController@logout')->name('wave.logout');
Route::get('user/verify/{verification_code}', '\Wave\Http\Controllers\Auth\RegisterController@verify')->name('verify');
Route::post('register/complete', '\Wave\Http\Controllers\Auth\RegisterController@complete')->name('wave.register-complete');

Route::get('blog', '\Wave\Http\Controllers\BlogController@index')->name('wave.blog');
Route::get('blog/{category}', '\Wave\Http\Controllers\BlogController@category')->name('wave.blog.category');
Route::get('blog/{category}/{post}', '\Wave\Http\Controllers\BlogController@post')->name('wave.blog.post');

Route::view('install', 'wave::install')->name('wave.install');

/***** Pages *****/
Route::get('p/{page}', '\Wave\Http\Controllers\PageController@page');

/***** Pricing Page *****/
Route::view('pricing', 'theme::pricing')->name('wave.pricing');

/***** Billing Routes *****/
Route::post('paddle/webhook', '\Wave\Http\Controllers\WebhookController');
Route::post('checkout', '\Wave\Http\Controllers\SubscriptionController@checkout')->name('checkout');

Route::get('test', '\Wave\Http\Controllers\SubscriptionController@test');

Route::group(['middleware' => 'wave'], function () {
	Route::get('dashboard', '\Wave\Http\Controllers\DashboardController@index')->name('wave.dashboard');
    Route::get('retirar', 'CashController@retirar')->name('retirar');
    
});

Route::group(['middleware' => ['auth']], function(){
	Route::get('settings/{section?}', '\Wave\Http\Controllers\SettingsController@index')->name('wave.settings');
	Route::get('settings/arbol/referidos', '\Wave\Http\Controllers\SettingsController@arbol')->name('wave.arbol');
	Route::post('settings/profile', '\Wave\Http\Controllers\SettingsController@profilePut')->name('wave.settings.profile.put');
	Route::put('settings/security', '\Wave\Http\Controllers\SettingsController@securityPut')->name('wave.settings.security.put');
    Route::get('iboxs', 'ReferidosController@ibox')->name('wave.ibox');
    Route::get('e-sports', 'GamesController@sports')->name('wave.esports');
	
	Route::get('system/inversion', 'InversionesPaquete@mostrar_paquetes')->name('wave.paquetes');
	Route::get('system/inversion/personal', 'InversionesPaquete@MisInversiones')->name('wave.paquetes.personal');
	Route::get('system/inversion/personal/{id}', 'InversionesPaquete@MisInversionesTransaccion')->name('wave.paquetes.personal.transaccion');

	Route::post('settings/api', '\Wave\Http\Controllers\SettingsController@apiPost')->name('wave.settings.api.post');
	Route::put('settings/api/{id?}', '\Wave\Http\Controllers\SettingsController@apiPut')->name('wave.settings.api.put');
	Route::delete('settings/api/{id?}', '\Wave\Http\Controllers\SettingsController@apiDelete')->name('wave.settings.api.delete');

	Route::get('settings/invoices/{invoice}', '\Wave\Http\Controllers\SubscriptionController@invoice')->name('wave.invoice');

	Route::get('notifications', '\Wave\Http\Controllers\NotificationController@index')->name('wave.notifications');
	Route::get('announcements', '\Wave\Http\Controllers\AnnouncementController@index')->name('wave.announcements');
	Route::get('announcement/{id}', '\Wave\Http\Controllers\AnnouncementController@announcement')->name('wave.announcement');
	Route::post('announcements/read', '\Wave\Http\Controllers\AnnouncementController@read')->name('wave.announcements.read');
	Route::get('notifications', '\Wave\Http\Controllers\NotificationController@index')->name('wave.notifications');
	Route::post('notification/read/{id}', '\Wave\Http\Controllers\NotificationController@delete')->name('wave.notification.read');

    /********** Checkout/Billing Routes ***********/
    Route::post('cancel', '\Wave\Http\Controllers\SubscriptionController@cancel')->name('wave.cancel');
    Route::view('checkout/welcome', 'theme::welcome');

    Route::post('subscribe', '\Wave\Http\Controllers\SubscriptionController@subscribe')->name('wave.subscribe');
	Route::view('trial_over', 'theme::trial_over')->name('wave.trial_over');
	Route::view('cancelled', 'theme::cancelled')->name('wave.cancelled');
    Route::post('switch-plans', '\Wave\Http\Controllers\SubscriptionController@switchPlans')->name('wave.switch-plans');



  /********** LogicaCasino***********/
  Route::get('transacciones', 'CashController@index')->name('wave.transaccion');
  Route::get('arbolreferidos', 'ReferidosController@ArbolMultiNivel')->name('referidos');
  Route::view('cash', 'theme::Cash')->name('cashmoney');
  /***** Logica money */
  Route::post('balance', 'CashController@addFunds')->name('cashbalance');

  Route::get('/transfer', 'CashController@tranfers')->name('payment.transfer');

  Route::post('balancebono', 'CashController@addFoundBono')->name('cashbalanceBono');
  Route::post('recargabalance', 'CashController@addFoundBalancerecarga')->name('addFoundBalancerecarga');
  
  Route::post('feeds', 'CashController@feeds')->name('feedsconfiguracion');
  Route::post('balanceinversion/{id}', 'CashController@addFoundinversion')->name('cashbalanceInversion');
  Route::post('balanceinversionbalance/{id}', 'CashController@addFoundinversionBalance')->name('cashbalanceInversionBalance');
  Route::post('balanceibox/{id}', 'IboxController@addFoundibox')->name('cashbalanceIbox');
  Route::post('balanceiboxbalance/{id}', 'IboxController@addFoundiboxBalance')->name('cashbalanceIboxBalance');


  Route::get('recargame', 'CashController@recargame')->name('recargame');

  Route::get('cash/invertir/{id}', 'InversionesPaquete@CompraPaqueteInversion')->name('cashinversion');
  Route::get('cash/ibox/{id}', 'InversionesPaquete@CompraPaqueteIbox')->name('cashibox');
  Route::get('inversioncasino/{id}', 'CashController@SendInversionToEfectivo')->name('wave.paquetes.casino');
  Route::post('retirosvitrix', 'CashController@retirosvitrix')->name('RetirosVitrix');

  Route::get('/juego', "GamesController@Genius")->name("unity-game");

  Route::get('/genius', "GamesController@Genius")->name("genius");
  Route::get('/navial', "GamesController@Navial")->name("navial");
  Route::get('cars/{id}', "GamesController@Cars")->name("cars");
  Route::get('/get-token', "GamesController@getToken")->name("GetToken");
  Route::get('/evento', "GamesController@ultimo_evento")->name("ultimoevento");
  Route::get('/sala/{id}', "GamesController@Salaspropias")->name("sala.detalle");

  Route::get('/eventoactual', "GamesController@naveseventos")->name("evento.actual");
  

  //enlaces


  Route::get('desafio/{id}', 'GamesController@desafio')->name('desafio');
  Route::get('desafio/{action}/{id}', 'GamesController@actiondesafio')->name('actiondesafio');
  Route::post('apuesta/{id_sala}', 'GamesController@apostarcars')->name('apostarcars');
  

  Route::post('procesadorpagares', 'FinanzasController@UsersPagos')->name('procesadorpagares');
  Route::post('blockchainvitrix', 'FinanzasController@blockchainvitrix')->name('blockchainvitrix');
  
});

Route::group(['middleware' => 'admin.user'], function(){
    Route::view('admin/do', 'wave::do');
});
