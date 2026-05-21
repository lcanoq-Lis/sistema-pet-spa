<?php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\User;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::with(['usuario', 'mascotas'])
            ->orderBy('nombre')
            ->get();

        return view('recepcion.clientes.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = Cliente::with([
            'usuario',
            'mascotas.vacunas',
            'mascotas.duenos',
        ])->findOrFail($id);

        // Historial de citas del cliente
        $citas = \App\Models\Cita::whereHas('mascota', function($q) use ($cliente) {
            $q->whereHas('duenos', function($q2) use ($cliente) {
                $q2->where('cliente_id', $cliente->id);
            });
        })->with(['mascota', 'servicio', 'groomer'])
          ->orderBy('fecha_hora_inicio', 'desc')
          ->get();

        return view('recepcion.clientes.show', compact('cliente', 'citas'));
    }
}