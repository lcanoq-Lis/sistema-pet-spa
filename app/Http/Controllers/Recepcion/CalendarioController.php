<?php
// app/Http/Controllers/Recepcion/CalendarioController.php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Groomer;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        $groomers      = Groomer::where('activo', true)->get();
        $groomerFiltro = $request->get('groomer', 'todos');
        return view('recepcion.calendario.index', compact('groomers', 'groomerFiltro'));
    }

    // Endpoint AJAX — devuelve citas en formato FullCalendar
    public function eventos(Request $request)
    {
        $inicio = $request->get('start');
        $fin    = $request->get('end');
        $groomer= $request->get('groomer', 'todos');

        $query = Cita::with(['mascota', 'servicio', 'groomer'])
            ->whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->whereNotIn('estado', ['cancelada']);

        if ($groomer !== 'todos') {
            $query->where('groomer_id', $groomer);
        }

        $citas = $query->get()->map(function($cita) {
            $colores = [
                'agendada'    => ['bg' => '#fff3e0', 'border' => '#ff9800', 'text' => '#e65100'],
                'confirmada'  => ['bg' => '#e8f5e9', 'border' => '#4caf50', 'text' => '#2e7d32'],
                'en_progreso' => ['bg' => '#e3f2fd', 'border' => '#2196f3', 'text' => '#1565c0'],
                'completada'  => ['bg' => '#f3e5f5', 'border' => '#9c27b0', 'text' => '#6a1b9a'],
                'en_revision' => ['bg' => '#fce4ec', 'border' => '#e91e63', 'text' => '#880e4f'],
            ];
            $c = $colores[$cita->estado] ?? ['bg' => '#f5f5f5', 'border' => '#ccc', 'text' => '#333'];

            return [
                'id'                => $cita->id,
                'title'             => "🐾 {$cita->mascota->nombre} — {$cita->servicio->nombre}",
                'start'             => $cita->fecha_hora_inicio->format('Y-m-d\TH:i:s'),
                'end'               => $cita->fecha_hora_fin_estimada->format('Y-m-d\TH:i:s'),
                'backgroundColor'   => $c['bg'],
                'borderColor'       => $c['border'],
                'textColor'         => $c['text'],
                'editable'          => in_array($cita->estado, ['agendada', 'confirmada', 'en_revision']),
                'extendedProps'     => [
                    'mascota'  => $cita->mascota->nombre,
                    'servicio' => $cita->servicio->nombre,
                    'groomer'  => $cita->groomer?->nombre ?? 'Sin asignar',
                    'estado'   => $cita->estado,
                    'precio'   => $cita->precio_acordado,
                ],
            ];
        });

        return response()->json($citas);
    }

    // Endpoint AJAX — guarda reprogramación por drag & drop
    public function moverCita(Request $request, $id)
    {
        $request->validate([
            'start' => 'required|date',
            'end'   => 'required|date',
        ]);

        $cita = Cita::findOrFail($id);

        if (!in_array($cita->estado, ['agendada', 'confirmada', 'en_revision'])) {
            return response()->json(['error' => 'No se puede reprogramar esta cita.'], 422);
        }

        $inicio = \Carbon\Carbon::parse($request->start);
        $fin    = \Carbon\Carbon::parse($request->end);

        // Verificar horario laboral y bloqueos
        $disponibilidad = \App\Http\Controllers\Admin\HorarioController::verificarDisponibilidad(
            $inicio->toDateString(),
            $inicio->format('H:i'),
            $cita->groomer_id
        );

        if (!$disponibilidad['disponible']) {
            return response()->json(['error' => $disponibilidad['motivo']], 422);
        }

        // Verificar solapamiento
        $solapamiento = Cita::where('groomer_id', $cita->groomer_id)
            ->where('id', '!=', $id)
            ->whereNotIn('estado', ['cancelada'])
            ->where('fecha_hora_inicio', '<', $fin)
            ->where('fecha_hora_fin_estimada', '>', $inicio)
            ->exists();

        if ($solapamiento) {
            return response()->json(['error' => 'El groomer ya tiene una cita en ese horario.'], 422);
        }

        $cita->fecha_hora_inicio       = $inicio;
        $cita->fecha_hora_fin_estimada = $fin;
        $cita->reprogramada_en         = now();
        $cita->save();

        // Notificar
        try {
            $cita = $cita->fresh(['mascota', 'servicio', 'groomer.usuario']);
            $cliente = \App\Models\User::find($cita->creado_por_usuario_id);
            if ($cliente) {
                \Illuminate\Support\Facades\Mail::send('emails.reprogramacion_cita', [
                    'cita' => $cita, 'usuario' => $cliente,
                ], function($m) use ($cliente) {
                    $m->to($cliente->email)->subject('📅 Tu cita ha sido reprogramada — Pet Spa');
                });
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error notif reprog drag: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Cita reprogramada correctamente.']);
    }
}
