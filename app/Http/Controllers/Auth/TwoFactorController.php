<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Google2FA;

class TwoFactorController extends Controller
{
    // Mostrar formulario para ingresar código 2FA
    public function index()
    {
        return view('auth.two-factor');
    }

    // Generar QR para configurar 2FA (solo admin)
   public function setup()
{
    $usuario = Auth::user();
    $google2fa = new Google2FA();

    if (!$usuario->two_factor_secret) {
        $secret = $google2fa->generateSecretKey();
        $usuario->two_factor_secret = $secret;
        $usuario->save();
    }

    $secret = $usuario->two_factor_secret;

    return view('auth.two-factor-setup', compact('secret'));
}

    // Activar 2FA después de escanear QR
    public function activate(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ]);

        $usuario = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($usuario->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto, intenta de nuevo.']);
        }

        $usuario->two_factor_enabled = true;
        $usuario->save();

        return redirect('/dashboard')->with('status', '2FA activado correctamente.');
    }

    // Verificar código 2FA en cada login
    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6'
        ]);

        $usuario = Auth::user();
        $google2fa = new Google2FA();

        $valid = $google2fa->verifyKey($usuario->two_factor_secret, $request->code);

        if (!$valid) {
            return back()->withErrors(['code' => 'Código incorrecto.']);
        }

        session(['2fa_verificado' => true]);

        return redirect('/dashboard');
    }
}