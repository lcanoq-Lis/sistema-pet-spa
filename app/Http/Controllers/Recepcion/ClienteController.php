<?php
// app/Http/Controllers/Recepcion/ClienteController.php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with(['usuario', 'mascotas'])
            ->orderBy('nombre')
            ->get();
        return view('recepcion.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('recepcion.clientes.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:100',
        'email'    => 'required|email|unique:users,email',
        'password' => [
            'required', 'min:8', 'confirmed',
            'regex:/[A-Z]/',
            'regex:/[a-z]/',
            'regex:/[0-9]/',
            'regex:/[@$!%*#?&]/',
        ],
        'telefono' => 'nullable|string|max:30',
        'ci'       => 'nullable|string|max:20',
    ], [
        'password.regex' => 'La contraseña debe tener mayúsculas, minúsculas, números y símbolos.',
    ]);

    $rolCliente = \App\Models\Role::where('nombre', 'cliente')->first();

    $token = \Illuminate\Support\Str::random(64);

    $usuario = \App\Models\User::create([
        'name'               => $request->name,
        'email'              => $request->email,
        'password'           => \Illuminate\Support\Facades\Hash::make($request->password),
        'rol_id'             => $rolCliente?->id,
        'email_verificado'   => false,
        'token_verificacion' => hash('sha256', $token),
        'token_expira_en'    => now()->addMinutes(15),
        'activo'             => false,
        'ci'                 => $request->ci,
    ]);

    $cliente = \App\Models\Cliente::create([
        'usuario_id' => $usuario->id,
        'nombre'     => $request->name,
        'apellido'   => $request->apellido,
        'telefono'   => $request->telefono,
        'direccion'  => $request->direccion,
    ]);

    // Enviar email de verificación
    $urlVerificacion = route('verificar.email', ['token' => $token, 'email' => $usuario->email]);
    \Illuminate\Support\Facades\Mail::send('emails.verificacion', [
        'url'    => $urlVerificacion,
        'nombre' => $request->name,
    ], function($m) use ($request) {
        $m->to($request->email)->subject('Activa tu cuenta - Pet Spa');
    });

    \App\Models\AuthLog::create([
        'usuario_id' => $usuario->id,
        'rol'        => 'cliente',
        'evento'     => 'registro',
        'ip'         => $request->ip(),
        'user_agent' => $request->userAgent(),
    ]);

    return redirect()->route('recepcion.clientes.index')
        ->with('status', "✅ Cliente {$request->name} registrado. Se envió email de verificación a {$request->email}.");
}

    public function show($id)
    {
        $cliente = Cliente::with([
            'usuario',
            'mascotas',
        ])->findOrFail($id);

        $citas = \App\Models\Cita::whereHas('mascota', function($q) use ($cliente) {
            $q->whereHas('duenos', function($q2) use ($cliente) {
                $q2->where('cliente_id', $cliente->id);
            });
        })->with(['mascota', 'servicio', 'groomer'])
          ->orderBy('fecha_hora_inicio', 'desc')
          ->get();

        return view('recepcion.clientes.show', compact('cliente', 'citas'));
    }

    public function createMascota($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        return view('recepcion.clientes.create_mascota', compact('cliente'));
    }

    public function storeMascota(Request $request, $clienteId)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'especie'  => 'required|in:perro,gato,conejo,hamster,ave,otro',
            'tamano'   => 'required|in:xs,s,m,l,xl',
            'peso_kg'  => 'nullable|numeric|min:0.1',
        ]);

        $cliente = Cliente::findOrFail($clienteId);

        $mascota = Mascota::create([
            'nombre'               => $request->nombre,
            'especie'              => $request->especie,
            'raza'                 => $request->raza,
            'tamano'               => $request->tamano,
            'peso_kg'              => $request->peso_kg,
            'fecha_nacimiento'     => $request->fecha_nacimiento,
            'temperamento'         => $request->temperamento,
            'alergias'             => $request->alergias,
            'restricciones_medicas'=> $request->restricciones_medicas,
            'activo'               => true,
        ]);

        // Asociar mascota al cliente
        \Illuminate\Support\Facades\DB::table('mascota_dueno')->insert([
            'mascota_id' => $mascota->id,
            'cliente_id' => $cliente->id,
            'es_primario' => true,
        ]);

        return redirect()->route('recepcion.clientes.show', $clienteId)
            ->with('status', 'Mascota registrada correctamente.');
    }
}
