<?php
// app/Http/Controllers/Recepcion/CalendarioController.php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Groomer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {
        // Semana actual o la que viene en el parámetro
        $semanaActual  = $request->get('semana', now()->format('Y-W'));
        $groomerFiltro = $request->get('groomer', 'todos');

        // Calcular días de la semana
        [$anio, $semana] = explode('-', $semanaActual);
        $inicioSemana = Carbon::now()->setISODate($anio, $semana)->startOfWeek(Carbon::MONDAY);
        $finSemana    = $inicioSemana->copy()->endOfWeek(Carbon::SUNDAY);

        $diasSemana    = collect();
        for ($i = 0; $i < 7; $i++) {
            $diasSemana->push($inicioSemana->copy()->addDays($i));
        }

        // Semanas anterior y siguiente
        $semanaAnterior = $inicioSemana->copy()->subWeek()->format('Y-W');
        $semanaProxima  = $inicioSemana->copy()->addWeek()->format('Y-W');

        // Horas del día (8am a 7pm)
        $horas = [];
        for ($h = 8; $h <= 19; $h++) {
            $horas[] = sprintf('%02d:00', $h);
            $horas[] = sprintf('%02d:30', $h);
        }

        // Query de citas
        $query = Cita::with(['mascota', 'servicio', 'groomer'])
            ->whereBetween('fecha_hora_inicio', [$inicioSemana, $finSemana])
            ->whereNotIn('estado', ['cancelada']);

        if ($groomerFiltro !== 'todos') {
            $query->where('groomer_id', $groomerFiltro);
        }

        $citas = $query->get();

        // Agrupar citas por fecha
        $citasPorDia = $citas->groupBy(function ($cita) {
            return $cita->fecha_hora_inicio->format('Y-m-d');
        });

        $groomers = Groomer::where('activo', true)->get();

        return view('recepcion.calendario.index', compact(
            'diasSemana', 'horas', 'citasPorDia',
            'semanaActual', 'semanaAnterior', 'semanaProxima',
            'groomers', 'groomerFiltro'
        ));
    }
}
