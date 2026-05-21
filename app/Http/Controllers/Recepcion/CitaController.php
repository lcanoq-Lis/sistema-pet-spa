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
        $citas = Cita::with(['mascota', 'servicio', 'groomer', 'creadoPor', 'pago'])
            ->orderBy('fecha_hora_inicio', 'asc')
            ->get();

        return view('recepcion.citas.index', compact('citas'));
    }

    public function confirmar($id)
{
    $cita = Cita::findOrFail($id);
    $cita->estado = 'confirmada';
    $cita->save();

    // Notificar al cliente
    NotificacionController::enviarConfirmacion($cita);

    // Notificar al groomer
    NotificacionController::enviarNotificacionGroomer($cita->load(['mascota', 'servicio', 'groomer.usuario']));

    return back()->with('status', 'Cita confirmada y notificaciones enviadas.');
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
    public function reprogramar(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora'  => 'required',
        ], [
            'fecha.required'       => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'hora.required'        => 'La hora es obligatoria.',
        ]);

        $cita = Cita::findOrFail($id);

        // 1. Obtener el nuevo inicio
        $inicio = \Carbon\Carbon::parse($request->fecha . ' ' . $request->hora);
        
        // 2. Forzar parseo de fechas antiguas
        $fechaInicioAntigua = \Carbon\Carbon::parse($cita->fecha_hora_inicio);
        $fechaFinAntigua    = \Carbon\Carbon::parse($cita->fecha_hora_fin_estimada);
        
        $duracion = abs($fechaFinAntigua->diffInMinutes($fechaInicioAntigua));
        
        if ($duracion === 0) {
            $duracion = 60; 
        }

        // 3. Calculamos el nuevo fin
        $fin = $inicio->copy()->addMinutes($duracion);

        if ($fin->lessThanOrEqualTo($inicio)) {
            return back()->withErrors(['hora' => 'Error crítico: La hora de finalización estimada no puede ser menor o igual al inicio.'])->withInput();
        }

        // 4. Verificar solapamiento y capacidad simultánea
        $citasEnHorario = Cita::where('groomer_id', $cita->groomer_id)
            ->where('id', '!=', $id)
            ->whereNotIn('estado', ['cancelada'])
            ->where('fecha_hora_inicio', '<', $fin)
            ->where('fecha_hora_fin_estimada', '>', $inicio)
            ->count();

        $groomer = Groomer::findOrFail($cita->groomer_id);

        if ($citasEnHorario >= $groomer->capacidad_simultanea) {
            return back()->withErrors([
                'hora' => $groomer->capacidad_simultanea == 1
                    ? 'El groomer ya tiene una cita en ese horario. Por favor elige otra hora.'
                    : "El groomer ya alcanzó su capacidad máxima ({$groomer->capacidad_simultanea} citas simultáneas) en ese horario."
            ])->withInput();
        }

        // 5. BLINDAJE CONTRA INTEGRIDAD DE BASE DE DATOS (Error 1452)
        // Verificamos dinámicamente si el ID del usuario autenticado existe en la tabla que MySQL está buscando.
        // Si no existe (debido a inconsistencias en la migración), le asignamos null para que no falle.
        $usuarioExiste = \Illuminate\Support\Facades\DB::table('users')->where('id', auth()->id())->exists() 
            || \Illuminate\Support\Facades\DB::table('usuarios')->where('id', auth()->id())->exists();

        // 6. Guardar cambios de reprogramación
        $cita->reprogramada_desde_id   = $cita->id;
        $cita->reprogramada_por_id     = $usuarioExiste ? auth()->id() : null; // Si no existe en la tabla relacional, se pone null
        $cita->reprogramada_en         = now();
        $cita->fecha_hora_inicio       = $inicio;
        $cita->fecha_hora_fin_estimada = $fin;
        $cita->estado                  = 'confirmada';
        $cita->save();

        return back()->with('status', 'Cita reprogramada correctamente.');
    }

    public function solicitudes()
    {
        $solicitudes = Cita::where('estado', 'en_revision')
            ->with(['mascota', 'servicio', 'groomer', 'creadoPor'])
            ->orderBy('creado_en', 'asc')
            ->get();

        return view('recepcion.solicitudes', compact('solicitudes'));
    }
}