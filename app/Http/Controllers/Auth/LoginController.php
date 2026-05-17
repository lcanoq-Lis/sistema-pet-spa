<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        $usuario = User::where('email', $request->email)->first();

        // Verificar si existe
        if (!$usuario) {
            return back()->withErrors(['email' => 'Credenciales incorrectas.']);
        }

        // Verificar si está bloqueado
        if ($usuario->estaBloqueado()) {
            $minutos = now()->diffInMinutes($usuario->bloqueado_hasta);
            return back()->withErrors([
                'email' => "Cuenta bloqueada. Intenta en {$minutos} minuto(s)."
            ]);
        }

        // Verificar si está activo
        if (!$usuario->estaActivo()) {
            return back()->withErrors(['email' => 'Tu cuenta está inactiva.']);
        }

        // Intentar login
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Sumar intento fallido
            $usuario->increment('intentos_fallidos');

            // Registrar log
            AuthLog::create([
                'usuario_id' => $usuario->id,
                'rol'        => $usuario->rol?->nombre,
                'evento'     => 'login_fallido',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Bloquear tras 5 intentos
            if ($usuario->intentos_fallidos >= 5) {
                $usuario->bloqueado_hasta = now()->addMinutes(15);
                $usuario->save();
                return back()->withErrors([
                    'email' => 'Demasiados intentos. Cuenta bloqueada por 15 minutos.'
                ]);
            }

            $restantes = 5 - $usuario->intentos_fallidos;
            return back()->withErrors([
                'email' => "Credenciales incorrectas. Te quedan {$restantes} intento(s)."
            ]);
        }

        // Login exitoso — resetear intentos
        $usuario->intentos_fallidos = 0;
        $usuario->bloqueado_hasta   = null;
        $usuario->ultimo_acceso     = now();
        $usuario->save();

        // Registrar log
        AuthLog::create([
            'usuario_id' => $usuario->id,
            'rol'        => $usuario->rol?->nombre,
            'evento'     => 'login',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

            $request->session()->regenerate();

    // Si es admin y tiene 2FA activado, redirigir a verificación
    if ($usuario->rol?->nombre === 'admin' && $usuario->two_factor_enabled) {
        session(['2fa_verificado' => false]);
        return redirect()->route('2fa.verify');
    }

    return redirect()->intended('/dashboard');
    }

    public function logout(Request $request)
    {
        $usuario = Auth::user();

        AuthLog::create([
            'usuario_id' => $usuario->id,
            'rol'        => $usuario->rol?->nombre,
            'evento'     => 'logout',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}