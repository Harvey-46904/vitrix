<?php

namespace App\Http\Middleware;



use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    protected $timeout;

    public function __construct()
    {
        $this->timeout = config('app.session_timeout'); 
    }

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $currentTime = time();
            $lastActivity = Session::get('lastActivityTime');

            // Si hay un valor previo y timeout está activado (>0), verificamos
            if ($lastActivity && $this->timeout > 0) {
                if (($currentTime - $lastActivity) > $this->timeout) {
                    Auth::logout();
                    Session::flush();
                    return redirect()->route('login')->with('message', 'Sesión cerrada por inactividad.');
                }
            }

            // Guardamos o actualizamos la actividad
            Session::put('lastActivityTime', $currentTime);
        }

        return $next($request);
    }
}