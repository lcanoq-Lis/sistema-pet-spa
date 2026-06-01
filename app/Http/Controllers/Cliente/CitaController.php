<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Groomer;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper;
use App\Http\Controllers\Admin\NotificacionController;

class CitaController extends Controller
{
    public function index()
    {
        $cliente = Cliente::where('usuario_id', Auth::id())->first();
        $citas   = Cita::whereHas('mascota', function ($q) use ($cliente) {
            $q->whereHas('duenos', function ($q2) use ($cliente) {
                $q2->where('cliente_id', $cliente->id);
            });
        })->with(['mascota', 'servicio', 'groomer.usuario'])
          ->orderBy('fecha_hora_inicio', 'desc')
          ->get();

        return view('cliente.citas.index', compact('citas'));
    }

    public function create()
    {
        $cliente   = Cliente::where('usuario_id', Auth::id())->first();
        $mascotas  = $cliente->mascotas()->where('activo', true)->get();
        $servicios = Servicio::where('activo', true)->get();
        $groomers  = Groomer::where('activo', true)->with('usuario')->get();

        return view('cliente.citas.create', compact('mascotas', 'servicios', 'groomers'));
    }

public function store(Request $request)
{
    $request->validate([
        'mascota_id'    => 'required|exists:mascotas,id',
        'servicio_id'   => 'required|exists:servicios,id',
        'groomer_id'    => 'nullable|exists:groomers,id',
        'fecha'         => 'required|date|after_or_equal:today',
        'hora'          => 'required',
        'notas_cliente' => 'nullable|string|max:500',
    ]);

    $servicio  = Servicio::findOrFail($request->servicio_id);
    $mascota   = \App\Models\Mascota::findOrFail($request->mascota_id);
    $duracion = $servicio->duracionParaTamano($mascota->tamano, $mascota->temperamento);

    $inicio = \Carbon\Carbon::parse($request->fecha . ' ' . $request->hora);
    $fin    = $inicio->copy()->addMinutes($duracion);

    // Asignar groomer automáticamente si no se eligió
    $groomerId = $request->groomer_id;
    if (!$groomerId) {
        $groomer   = Groomer::where('activo', true)->first();
        $groomerId = $groomer?->id;
    }
    // Verificar horario laboral y bloqueos
    $disponibilidad = \App\Http\Controllers\Admin\HorarioController::verificarDisponibilidad(
        $request->fecha,
        $request->hora,
        $groomerId
    );

    if (!$disponibilidad['disponible']) {
        return back()->withErrors([
            'hora' => $disponibilidad['motivo']
        ])->withInput();
    }
   // Verificar solapamiento Y capacidad simultánea
$citasEnHorario = Cita::where('groomer_id', $groomerId)
    ->whereNotIn('estado', ['cancelada'])
    ->where('fecha_hora_inicio', '<', $fin)
    ->where('fecha_hora_fin_estimada', '>', $inicio)
    ->count();

$groomer = Groomer::findOrFail($groomerId);

if ($citasEnHorario >= $groomer->capacidad_simultanea) {
    return back()->withErrors([
        'hora' => $groomer->capacidad_simultanea == 1
            ? 'El groomer ya tiene una cita en ese horario. Por favor elige otra hora.'
            : "El groomer ya alcanzó su capacidad máxima ({$groomer->capacidad_simultanea} citas simultáneas) en ese horario."
    ])->withInput();
}

    // Crear la cita
    $cita = Cita::create([
        'mascota_id'              => $request->mascota_id,
        'groomer_id'              => $groomerId,
        'servicio_id'             => $request->servicio_id,
        'creado_por_usuario_id'   => Auth::id(),
        'estado'                  => 'en_revision',
        'fecha_hora_inicio'       => $inicio,
        'fecha_hora_fin_estimada' => $fin,
        'precio_acordado'         => $servicio->precio_base,
        'notas_cliente'           => $request->notas_cliente,
    ]);

    // Notificar al groomer
    NotificacionController::enviarNotificacionGroomer(
        $cita->load(['mascota', 'servicio', 'groomer.usuario'])
    );
// Notificar a recepción
NotificacionController::enviarNotificacionRecepcion($cita);
    // Log
    LogHelper::registrar('cita_creada', "Cita creada para mascota: {$mascota->nombre} - Servicio: {$servicio->nombre}");

    return redirect()->route('cliente.citas.index')
    ->with('status', '¡Cita solicitada correctamente! Está en revisión, la recepción la confirmará pronto. 📅');
}

public function destroy(Request $request, $id)
{
    $cliente = Cliente::where('usuario_id', Auth::id())->first();
    $cita    = Cita::whereHas('mascota', function ($q) use ($cliente) {
        $q->whereHas('duenos', function ($q2) use ($cliente) {
            $q2->where('cliente_id', $cliente->id);
        });
    })->findOrFail($id);

    if (!in_array($cita->estado, ['agendada', 'confirmada', 'en_revision'])) {
        return back()->withErrors(['error' => 'No puedes cancelar esta cita.']);
    }

    // Validar política de cancelación — mínimo 24h de anticipación
   $horasRestantes = now()->diffInHours($cita->fecha_hora_inicio, false);
$horasMinimas = (int) \App\Models\Configuracion::obtener('horas_cancelacion', 24);

if ($horasRestantes < $horasMinimas) {
    return back()->withErrors([
        'error' => "No puedes cancelar con menos de {$horasMinimas} horas de anticipación. Tu cita es el {$cita->fecha_hora_inicio->format('d/m/Y')} a las {$cita->fecha_hora_inicio->format('H:i')}."
    ]);
}

    $cita->estado             = 'cancelada';
    $cita->motivo_cancelacion = $request->motivo ?? 'Cancelada por el cliente';
    $cita->save();

    LogHelper::registrar('cita_cancelada', "Cita #{$id} cancelada. Motivo: {$cita->motivo_cancelacion}");

    return redirect()->route('cliente.citas.index')
        ->with('status', 'Cita cancelada correctamente.');
}
    public function historial()
{
    $cliente = Cliente::where('usuario_id', Auth::id())->first();

    $historial = Cita::whereHas('mascota', function ($q) use ($cliente) {
        $q->whereHas('duenos', function ($q2) use ($cliente) {
            $q2->where('cliente_id', $cliente->id);
        });
    })->with(['mascota', 'servicio', 'groomer'])
      ->whereIn('estado', ['completada', 'cancelada', 'no_asistio'])
      ->orderBy('fecha_hora_inicio', 'desc')
      ->get();

    return view('cliente.historial', compact('historial'));
}
}