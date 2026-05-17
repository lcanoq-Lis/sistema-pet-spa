<?php

namespace App\Http\Controllers\Groomer;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Groomer;
use App\Http\Controllers\Admin\NotificacionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendaController extends Controller
{
    public function index()
    {
        $groomer = Groomer::where('usuario_id', Auth::id())->first();

        if (!$groomer) {
            return redirect('/dashboard')->withErrors(['error' => 'No tienes perfil de groomer.']);
        }

        $hoy = now()->startOfDay();
        $fin = now()->endOfDay();

        $citasHoy = Cita::where('groomer_id', $groomer->id)
            ->whereBetween('fecha_hora_inicio', [$hoy, $fin])
            ->whereNotIn('estado', ['cancelada'])
            ->with(['mascota', 'servicio'])
            ->orderBy('fecha_hora_inicio')
            ->get();

        $citasPendientes = Cita::where('groomer_id', $groomer->id)
            ->where('fecha_hora_inicio', '>', now())
            ->whereNotIn('estado', ['cancelada', 'completada'])
            ->with(['mascota', 'servicio'])
            ->orderBy('fecha_hora_inicio')
            ->take(10)
            ->get();

        return view('groomer.agenda.index', compact('groomer', 'citasHoy', 'citasPendientes'));
    }

    public function confirmar($id)
    {
        $groomer = Groomer::where('usuario_id', Auth::id())->first();
        $cita    = Cita::where('groomer_id', $groomer->id)->findOrFail($id);
        $cita->estado = 'confirmada';
        $cita->save();

        $cita->load(['mascota', 'servicio']);
        NotificacionController::enviarConfirmacion($cita);

        return back()->with('status', 'Cita confirmada y cliente notificado.');
    }

    public function cancelar(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|min:10',
        ], [
            'motivo.required' => 'Debes ingresar el motivo de cancelación.',
            'motivo.min'      => 'El motivo debe tener al menos 10 caracteres.',
        ]);

        $groomer = Groomer::where('usuario_id', Auth::id())->first();
        $cita    = Cita::where('groomer_id', $groomer->id)->findOrFail($id);
        $cita->estado             = 'cancelada';
        $cita->motivo_cancelacion = $request->motivo;
        $cita->save();

        return back()->with('status', 'Cita cancelada correctamente.');
    }
}