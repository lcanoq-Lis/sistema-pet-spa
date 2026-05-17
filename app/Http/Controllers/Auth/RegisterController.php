<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthLog;
use App\Models\Cliente;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => [
                'required', 'min:8', 'confirmed',
                'regex:/[A-Z]/',      // mayúscula
                'regex:/[a-z]/',      // minúscula
                'regex:/[0-9]/',      // número
                'regex:/[@$!%*#?&]/', // símbolo
            ],
            'telefono' => 'nullable|string|max:30',
        ], [
            'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas, números y símbolos.',
        ]);

        $rolCliente = Role::where('nombre', 'cliente')->first();

        // Generar token de verificación
        $token = Str::random(64);

        $usuario = User::create([
            'name'                => $request->name,
            'email'               => $request->email,
            'password'            => Hash::make($request->password),
            'rol_id'              => $rolCliente?->id,
            'email_verificado'    => false,
            'token_verificacion'  => hash('sha256', $token),
            'token_expira_en'     => now()->addMinutes(15),
            'activo'              => false,
        ]);

        // Crear perfil de cliente
       Cliente::create([
            'usuario_id' => $usuario->id,
            'nombre'     => $request->name,
            'telefono'   => $request->telefono,
]);

        // Enviar email de verificación
        $urlVerificacion = route('verificar.email', ['token' => $token, 'email' => $usuario->email]);

        Mail::send('emails.verificacion', ['url' => $urlVerificacion, 'nombre' => $request->name], function ($m) use ($request) {
            $m->to($request->email)->subject('Activa tu cuenta - Pet Spa');
        });

        AuthLog::create([
            'usuario_id' => $usuario->id,
            'rol'        => 'cliente',
            'evento'     => 'registro',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect('/login')->with('status', 'Cuenta creada. Revisa tu correo para activarla (válido 15 minutos).');
    }
}