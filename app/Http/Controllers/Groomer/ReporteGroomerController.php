<?php

namespace App\Http\Controllers\Groomer;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Groomer;
use App\Models\InsumoGrooming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReporteGroomerController extends Controller
{
    public function index(Request $request)
    {
        $groomer = Groomer::where('usuario_id', Auth::id())->firstOrFail();

        $mes  = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin    = Carbon::create($anio, $mes, 1)->endOfMonth();

        // Citas del mes
        $citas = Cita::where('groomer_id', $groomer->id)
            ->whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->with(['mascota', 'servicio'])
            ->orderBy('fecha_hora_inicio')
            ->get();

        $citasCompletadas = $citas->where('estado', 'completada');
        $citasCanceladas  = $citas->where('estado', 'cancelada');

        // Ingresos generados
        $ingresosGenerados = $citasCompletadas->sum('precio_acordado');

        // Insumos usados en el mes
        $insumosUsados = InsumoGrooming::whereHas('ficha', function ($q) use ($groomer, $inicio, $fin) {
                $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id));
            })
            ->whereBetween('creado_en', [$inicio, $fin])
            ->where('estado', '!=', 'devuelto')
            ->with('producto')
            ->get();

        // Agrupar insumos por producto
        $insumosAgrupados = $insumosUsados->groupBy('producto_id')->map(function ($items) {
            return [
                'nombre'   => $items->first()->producto->nombre ?? '—',
                'cantidad' => $items->sum('cantidad'),
                'unidad'   => $items->first()->unidad,
            ];
        })->values();

        // Citas por día de la semana
        $citasPorDia = $citasCompletadas->groupBy(fn($c) => $c->fecha_hora_inicio->locale('es')->dayName)
            ->map->count();

        // Meses disponibles para el selector
        $meses = collect(range(1, 12))->map(fn($m) => [
            'numero' => $m,
            'nombre' => Carbon::create(null, $m)->locale('es')->monthName,
        ]);

        return view('groomer.reportes.index', compact(
            'groomer', 'citas', 'citasCompletadas', 'citasCanceladas',
            'ingresosGenerados', 'insumosAgrupados', 'citasPorDia',
            'mes', 'anio', 'meses', 'inicio', 'fin'
        ));
    }
}
