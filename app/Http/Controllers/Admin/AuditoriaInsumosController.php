<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Groomer;
use App\Models\InsumoGroomer;
use App\Models\InsumoGrooming;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuditoriaInsumosController extends Controller
{
    public function index(Request $request)
    {
        $mes  = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);

        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin    = Carbon::create($anio, $mes, 1)->endOfMonth();

        $groomers = Groomer::where('activo', true)->with('usuario')->get();

        $auditoria = $groomers->map(function ($groomer) use ($inicio, $fin) {
            // Insumos entregados al groomer en el período
            $entregados = InsumoGroomer::where('groomer_id', $groomer->usuario_id)
                ->whereBetween('fecha_entrega', [$inicio, $fin])
                ->sum('cantidad_entregada');

            $devueltos = InsumoGroomer::where('groomer_id', $groomer->usuario_id)
                ->whereBetween('fecha_entrega', [$inicio, $fin])
                ->sum('cantidad_devuelta');

            // Insumos usados en fichas de grooming
            $usados = InsumoGrooming::whereHas('ficha', function ($q) use ($groomer, $inicio, $fin) {
                    $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id));
                })
                ->whereBetween('creado_en', [$inicio, $fin])
                ->where('estado', '!=', 'devuelto')
                ->sum('cantidad');

            $diferencia = $entregados - $devueltos - $usados;

            // Detalle por producto
            $detalle = InsumoGrooming::whereHas('ficha', function ($q) use ($groomer, $inicio, $fin) {
                    $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id));
                })
                ->whereBetween('creado_en', [$inicio, $fin])
                ->with('producto')
                ->get()
                ->groupBy('producto_id')
                ->map(fn($items) => [
                    'nombre'   => $items->first()->producto->nombre ?? '—',
                    'usado'    => $items->where('estado', '!=', 'devuelto')->sum('cantidad'),
                    'devuelto' => $items->where('estado', 'devuelto')->sum('cantidad'),
                ])->values();

            return [
                'groomer'     => $groomer,
                'entregados'  => $entregados,
                'usados'      => $usados,
                'devueltos'   => $devueltos,
                'diferencia'  => $diferencia,
                'alerta'      => $diferencia < 0,
                'detalle'     => $detalle,
            ];
        });

        $meses = collect(range(1, 12))->map(fn($m) => [
            'numero' => $m,
            'nombre' => Carbon::create(null, $m)->locale('es')->monthName,
        ]);

        return view('admin.auditoria.insumos', compact('auditoria', 'mes', 'anio', 'meses'));
    }
}
