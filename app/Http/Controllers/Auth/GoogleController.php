<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\Cliente;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['email' => 'Error al autenticar con Google.']);
        }

        // Buscar si ya existe el usuario
        $usuario = User::where('email', $googleUser->getEmail())->first();

        if (!$usuario) {
            // Crear usuario nuevo
            $rolCliente = Role::where('nombre', 'cliente')->first();

            $usuario = User::create([
                'name'             => $googleUser->getName(),
                'email'            => $googleUser->getEmail(),
                'password'         => bcrypt(\Illuminate\Support\Str::random(24)),
                'rol_id'           => $rolCliente?->id,
                'proveedor_oauth'  => 'google',
                'oauth_id'         => $googleUser->getId(),
                'email_verificado' => true,
                'activo'           => true,
            ]);

            // Crear perfil cliente
            Cliente::create([
                'usuario_id' => $usuario->id,
                'nombre'     => $googleUser->getName(),
            ]);
        }

        // Verificar si está activo
        if (!$usuario->estaActivo()) {
            return redirect('/login')->withErrors(['email' => 'Tu cuenta está inactiva.']);
        }

        Auth::login($usuario);

        // Log
        AuthLog::create([
            'usuario_id' => $usuario->id,
            'rol'        => $usuario->rol?->nombre,
            'evento'     => 'login_google',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect('/dashboard');
    }
}