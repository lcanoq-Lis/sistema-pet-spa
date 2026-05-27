<?php
// app/Http/Controllers/Cliente/PerfilController.php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function edit()
    {
        $usuario = Auth::user();
        $cliente = Cliente::where('usuario_id', $usuario->id)->first();
        return view('cliente.perfil.edit', compact('usuario', 'cliente'));
    }

    public function update(Request $request)
    {
        $usuario = Auth::user();
        $cliente = Cliente::where('usuario_id', $usuario->id)->first();

        $request->validate([
            'name'     => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'ci'       => 'nullable|string|max:20',
            'direccion'=> 'nullable|string|max:200',
        ]);

        // Actualizar usuario
        $usuario->name = $request->name;
        $usuario->ci   = $request->ci;
        $usuario->save();

        // Actualizar cliente
        if ($cliente) {
            $cliente->nombre   = $request->name;
            $cliente->apellido = $request->apellido;
            $cliente->telefono = $request->telefono;
            $cliente->direccion= $request->direccion;
            $cliente->save();
        }

        return back()->with('status', '✅ Perfil actualizado correctamente.');
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'password_actual' => 'required',
            'password'        => [
                'required', 'min:8', 'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/',
            ],
        ], [
            'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas, números y símbolos.',
        ]);

        $usuario = Auth::user();

        if (!Hash::check($request->password_actual, $usuario->password)) {
            return back()->withErrors(['password_actual' => 'La contraseña actual es incorrecta.']);
        }

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return back()->with('status', '✅ Contraseña actualizada correctamente.');
    }
}
