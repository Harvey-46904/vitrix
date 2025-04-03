<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\UserObserver;
use App\Observers\InversionesObserver;
use TCG\Voyager\Facades\Voyager;
use App\Models\User;
use App\Models\Inversione;

use App\Models\UserPaquete;
use App\Observers\UserPaquetesObserver;

use App\Models\Sala;
use App\Observers\SalaObserver;


use App\Models\Evento;
use App\Observers\EventoObserver;

//use TCG\Voyager\Models\User as VoyagerUser;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        Voyager::addAction(\App\Actions\RentabilidadesButton::class);
        Voyager::addAction(\App\Actions\ReferidoJuegos::class);
        
        User::observe(UserObserver::class);
        UserPaquete::observe(UserPaquetesObserver::class);
        Sala::observe(SalaObserver::class);
        Inversione::observe(InversionesObserver::class);
        Evento::observe(EventoObserver::class);
        if ($this->app->environment() == 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        $this->setSchemaDefaultLength();

        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = ['png', 'jpg', 'svg', 'jpeg'];
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );

            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }

            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }

            return true;
        });
    }

    private function setSchemaDefaultLength(): void
    {
        try {
            Schema::defaultStringLength(191);
        }
        catch (\Exception $exception){}
    }
}
