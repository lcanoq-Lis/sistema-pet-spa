<?php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Groomer;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\NotificacionController;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with(['mascota', 'servicio', 'groomer', 'creadoPor'])
            ->orderBy('fecha_hora_inicio', 'asc')
            ->get();

        return view('recepcion.citas.index', compact('citas'));
    }

    public function confirmar($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'confirmada';
        $cita->save();
        NotificacionController::enviarConfirmacion($cita);
        return back()->with('status', 'Cita confirmada correctamente.');
    }

    public function iniciar($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'en_progreso';
        $cita->save();

        return back()->with('status', 'Cita marcada como en progreso.');
    }

    public function completar($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'completada';
        $cita->save();
        NotificacionController::enviarListaParaRecoger($cita);
        return back()->with('status', 'Cita completada correctamente.');
    }

    public function cancelar(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $cita->estado = 'cancelada';
        $cita->motivo_cancelacion = $request->motivo;
        $cita->save();

        return back()->with('status', 'Cita cancelada.');
    }
}