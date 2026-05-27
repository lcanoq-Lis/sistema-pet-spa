<?php
// app/Http/Controllers/Admin/HorarioController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloqueoAgenda;
use App\Models\Groomer;
use App\Models\HorarioSpa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    // ── Horario laboral ──────────────────────────────────────────

    public function index()
    {
        $horarios = HorarioSpa::orderBy('dia_semana')->get();
        $bloqueos = BloqueoAgenda::with(['groomer', 'creadoPor'])
            ->orderBy('fecha_inicio', 'desc')
            ->get();
        $groomers = Groomer::where('activo', true)->get();

        return view('admin.horarios.index', compact('horarios', 'bloqueos', 'groomers'));
    }

    public function actualizarHorario(Request $request)
    {
        $request->validate([
            'horarios'                  => 'required|array',
            'horarios.*.dia_semana'     => 'required|integer|between:0,6',
            'horarios.*.hora_apertura'  => 'required|date_format:H:i',
            'horarios.*.hora_cierre'    => 'required|date_format:H:i|after:horarios.*.hora_apertura',
        ]);

        foreach ($request->horarios as $data) {
            HorarioSpa::where('dia_semana', $data['dia_semana'])->update([
                'hora_apertura' => $data['hora_apertura'],
                'hora_cierre'   => $data['hora_cierre'],
                'activo'        => isset($data['activo']) ? true : false,
            ]);
        }

        return back()->with('status', 'Horario laboral actualizado correctamente.');
    }

    // ── Bloqueos ─────────────────────────────────────────────────

    public function storeBloqueo(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
            'tipo'         => 'required|in:feriado,mantenimiento,ausencia,otro',
            'motivo'       => 'required|string|max:200',
            'groomer_id'   => 'nullable|exists:groomers,id',
        ]);

        BloqueoAgenda::create([
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'tipo'         => $request->tipo,
            'motivo'       => $request->motivo,
            'groomer_id'   => $request->groomer_id ?: null,
            'creado_por'   => Auth::id(),
        ]);

        return back()->with('status', 'Bloqueo registrado correctamente.');
    }

    public function destroyBloqueo($id)
    {
        BloqueoAgenda::findOrFail($id)->delete();
        return back()->with('status', 'Bloqueo eliminado.');
    }

    // ── Helper estático para validar disponibilidad ──────────────

    /**
     * Verifica si una fecha y hora están dentro del horario laboral
     * y no caen en un bloqueo activo.
     *
     * @param string $fecha       formato Y-m-d
     * @param string $hora        formato H:i
     * @param int|null $groomerId para verificar bloqueos específicos del groomer
     * @return array ['disponible' => bool, 'motivo' => string]
     */
    public static function verificarDisponibilidad(string $fecha, string $hora, ?int $groomerId = null): array
    {
        $diaSemana = (int) date('w', strtotime($fecha));

        // 1. Verificar horario laboral
        $horario = HorarioSpa::where('dia_semana', $diaSemana)->first();
        if (!$horario || !$horario->activo) {
            $dias = HorarioSpa::$dias;
            return ['disponible' => false, 'motivo' => "El spa no atiende los {$dias[$diaSemana]}."];
        }

        if ($hora < substr($horario->hora_apertura, 0, 5) || $hora >= substr($horario->hora_cierre, 0, 5)) {
            return [
                'disponible' => false,
                'motivo'     => "El horario de atención es de {$horario->hora_apertura} a {$horario->hora_cierre}.",
            ];
        }

        // 2. Verificar bloqueos generales del spa
        $bloqueado = BloqueoAgenda::whereNull('groomer_id')
            ->where('fecha_inicio', '<=', $fecha)
            ->where('fecha_fin', '>=', $fecha)
            ->first();

        if ($bloqueado) {
            return ['disponible' => false, 'motivo' => "Día bloqueado: {$bloqueado->motivo}"];
        }

        // 3. Verificar bloqueo específico del groomer
        if ($groomerId) {
            $bloqueadoGroomer = BloqueoAgenda::where('groomer_id', $groomerId)
                ->where('fecha_inicio', '<=', $fecha)
                ->where('fecha_fin', '>=', $fecha)
                ->first();

            if ($bloqueadoGroomer) {
                return ['disponible' => false, 'motivo' => "El groomer no está disponible: {$bloqueadoGroomer->motivo}"];
            }
        }

        return ['disponible' => true, 'motivo' => ''];
    }
}
