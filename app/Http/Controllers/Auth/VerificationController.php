<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verificar(Request $request)
    {
        $usuario = User::where('email', $request->email)
            ->where('token_verificacion', hash('sha256', $request->token))
            ->first();

        if (!$usuario) {
            return redirect('/login')->withErrors(['email' => 'Token inválido.']);
        }

        if (now()->gt($usuario->token_expira_en)) {
            return redirect('/login')->withErrors(['email' => 'El link expiró. Regístrate de nuevo.']);
        }

        $usuario->email_verificado   = true;
        $usuario->activo             = true;
        $usuario->token_verificacion = null;
        $usuario->token_expira_en    = null;
        $usuario->save();

        return redirect('/login')->with('status', '¡Cuenta activada! Ya puedes iniciar sesión.');
    }
}