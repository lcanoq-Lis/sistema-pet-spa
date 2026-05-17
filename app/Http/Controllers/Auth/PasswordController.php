<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\LogHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordController extends Controller
{
    // ── Mostrar formulario cambiar contraseña (usuario logueado)
    public function showCambiar()
    {
        return view('auth.cambiar-password');
    }

    public function cambiar(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password_nuevo'  => [
                'required', 'min:8', 'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ], [
            'password_nuevo.regex' => 'La contraseña debe tener mayúsculas, minúsculas, números y símbolos.',
        ]);

        $usuario = Auth::user();

        if (!Hash::check($request->password_actual, $usuario->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        $usuario->password = Hash::make($request->password_nuevo);
        $usuario->save();

        LogHelper::registrar('cambio_contrasena', 'El usuario cambió su contraseña.');

        return redirect('/dashboard')->with('status', 'Contraseña actualizada correctamente.');
    }

    // ── Mostrar formulario recuperar contraseña (sin login)
    public function showRecuperar()
    {
        return view('auth.recuperar-password');
    }

    public function recuperar(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'No encontramos una cuenta con ese correo.',
        ]);

        $usuario = User::where('email', $request->email)->first();

        // Generar token de recuperación
        $token = Str::random(64);
        $usuario->token_verificacion = hash('sha256', $token);
        $usuario->token_expira_en    = now()->addMinutes(15);
        $usuario->save();

        $url = route('password.reset.form', ['token' => $token, 'email' => $usuario->email]);

        Mail::send('emails.recuperar_password', [
            'nombre' => $usuario->name,
            'url'    => $url,
        ], function ($m) use ($usuario) {
            $m->to($usuario->email)->subject('Recuperar contraseña - Pet Spa');
        });

        LogHelper::registrar('recuperar_contrasena', "Solicitud de recuperación para: {$usuario->email}");

        return back()->with('status', 'Te enviamos un link de recuperación. Válido por 15 minutos.');
    }

    // ── Mostrar formulario nueva contraseña
    public function showReset(Request $request)
{
    return view('auth.reset-password', [
        'token' => $request->token,
        'email' => $request->email,
    ]);
}

    public function reset(Request $request)
{
    $request->validate([
        'email'    => 'required|email|exists:users,email',
        'token'    => 'required',
        'password' => [
            'required', 'min:8', 'confirmed',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
    ], [
        'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas, números y símbolos.',
    ]);

    $usuario = User::where('email', $request->email)->first();

    if (!$usuario || !$usuario->token_verificacion) {
        return back()->withErrors(['token' => 'Token inválido o expirado.']);
    }

    if ($usuario->token_verificacion !== hash('sha256', $request->token)) {
        return back()->withErrors(['token' => 'Token inválido.']);
    }

    if (now()->gt($usuario->token_expira_en)) {
        return back()->withErrors(['token' => 'El link expiró. Solicita uno nuevo.']);
    }

    $usuario->password           = Hash::make($request->password);
    $usuario->token_verificacion = null;
    $usuario->token_expira_en    = null;
    $usuario->save();

    LogHelper::registrar('reset_contrasena', "Contraseña restablecida para: {$usuario->email}");

    return redirect('/login')->with('status', 'Contraseña restablecida correctamente. Ya puedes iniciar sesión.');
}
}