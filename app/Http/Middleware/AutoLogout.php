<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AutoLogout
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
                // Verificar 2FA para admin
            if (Auth::user()->rol?->nombre === 'admin' && 
                Auth::user()->two_factor_enabled && 
                !session('2fa_verificado') &&
                !$request->routeIs('2fa.verify') &&
                !$request->routeIs('2fa.verify.post')) {
                return redirect()->route('2fa.verify');
            }
                $ultimaActividad = session('ultima_actividad');

            if ($ultimaActividad && (time() - $ultimaActividad) > (30 * 60)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect('/login')->withErrors([
                    'email' => 'Tu sesión expiró por inactividad. Inicia sesión de nuevo.'
                ]);
            }

            session(['ultima_actividad' => time()]);
        }

        return $next($request);
    }
}