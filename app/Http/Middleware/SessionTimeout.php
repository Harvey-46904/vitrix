<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class SessionTimeout
{
    protected $timeout = 900; // 15 minutos = 900 segundos

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = Session::get('lastActivityTime');
            $currentTime = time();

            if ($lastActivity && ($currentTime - $lastActivity) > $this->timeout) {
                Auth::logout();
                Session::flush();

                return redirect()->route('login')->with('message', 'Sesión cerrada por inactividad.');
            }

            Session::put('lastActivityTime', $currentTime);
        }

        return $next($request);
    }
}