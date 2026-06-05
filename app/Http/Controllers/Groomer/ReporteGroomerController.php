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
 // Método exportarPDF — agregar dentro de la clase ReporteGroomerController
public function exportarPDF(Request $request)
{
    $groomer = \App\Models\Groomer::where('usuario_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();
    $mes  = $request->get('mes', now()->month);
    $anio = $request->get('anio', now()->year);
    $inicio = \Carbon\Carbon::create($anio, $mes, 1)->startOfMonth();
    $fin    = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth();

    $citas = \App\Models\Cita::where('groomer_id', $groomer->id)->whereBetween('fecha_hora_inicio', [$inicio, $fin])->with(['mascota','servicio'])->orderBy('fecha_hora_inicio')->get();
    $citasCompletadas = $citas->where('estado','completada');
    $citasCanceladas  = $citas->where('estado','cancelada');
    $ingresosGenerados = $citasCompletadas->sum('precio_acordado');
    $insumosUsados = \App\Models\InsumoGrooming::whereHas('ficha', fn($q) => $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id)))->whereBetween('creado_en', [$inicio, $fin])->where('estado','!=','devuelto')->with('producto')->get();
    $insumosAgrupados = $insumosUsados->groupBy('producto_id')->map(fn($items) => ['nombre'=>$items->first()->producto->nombre??'—','cantidad'=>$items->sum('cantidad'),'unidad'=>$items->first()->unidad])->values();

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('groomer.reportes.pdf', compact('groomer','citas','citasCompletadas','citasCanceladas','ingresosGenerados','insumosAgrupados','inicio','anio'));
    return $pdf->download('reporte-groomer-' . $mes . '-' . $anio . '.pdf');
}

public function exportarExcel(Request $request)
{
    $mes  = $request->get('mes', now()->month);
    $anio = $request->get('anio', now()->year);
    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\ReporteGroomerExport(\Illuminate\Support\Facades\Auth::id(), $mes, $anio),
        'reporte-groomer-' . $mes . '-' . $anio . '.xlsx'
    );
}

// ── AGREGAR AL ReporteClienteController ──────────────────────────

public function descargarPDF()
{
    $cliente = \App\Models\Cliente::where('usuario_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();
    $historial = \App\Models\Cita::whereHas('mascota', fn($q) => $q->whereHas('duenos', fn($q2) => $q2->where('cliente_id', $cliente->id)))->with(['mascota','servicio','pago'])->whereIn('estado',['completada','cancelada','no_asistio'])->orderByDesc('fecha_hora_inicio')->get();
    $mascotas = $cliente->mascotas()->where('activo', true)->get();
    $puntosTotales = \App\Models\PuntoCliente::where('cliente_id', \Illuminate\Support\Facades\Auth::id())->sum('puntos');
    $totalCitas = $historial->where('estado','completada')->count();
    $totalGastado = $historial->where('estado','completada')->sum(fn($c) => $c->pago?->total ?? $c->precio_acordado);
    $servicioFavorito = $historial->where('estado','completada')->groupBy('servicio_id')->map->count()->sortDesc()->keys()->first();
    $servicioFavoritoNombre = $historial->where('servicio_id',$servicioFavorito)->first()?->servicio?->nombre ?? '—';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cliente.reportes.pdf', compact('cliente','historial','mascotas','puntosTotales','totalCitas','totalGastado','servicioFavoritoNombre'));
    return $pdf->download('mi-historial-pet-spa.pdf');
}

public function descargarExcel()
{
    return \Maatwebsite\Excel\Facades\Excel::download(
        new \App\Exports\ReporteClienteExport(\Illuminate\Support\Facades\Auth::id()),
        'mi-historial-pet-spa.xlsx'
    );
}

}
