<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Groomer;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $hoy = Carbon::today();
        $mes  = $request->get('mes', $hoy->month);
        $anio = $request->get('anio', $hoy->year);

        // KPIs principales
        $totalClientes      = User::whereHas('rol', fn($q) => $q->where('nombre', 'cliente'))->count();
        $citasHoy           = Cita::whereDate('fecha_hora_inicio', $hoy)->whereNotIn('estado', ['cancelada'])->count();
        $citasMes           = Cita::whereMonth('fecha_hora_inicio', $hoy->month)->whereNotIn('estado', ['cancelada'])->count();
        $totalGroomers      = Groomer::where('activo', true)->count();
        $citasCompletadas   = Cita::where('estado', 'completada')->count();
        $citasCanceladas    = Cita::where('estado', 'cancelada')->count();
        $productosBajoStock = Producto::where('activo', true)->whereColumn('stock', '<=', 'stock_minimo')->count();

        $ingresosMes = Cita::where('estado', 'completada')
            ->whereMonth('fecha_hora_inicio', $hoy->month)
            ->sum('precio_acordado');

        $citasPorEstado = Cita::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $topServicios = Cita::selectRaw('servicio_id, COUNT(*) as total')
            ->whereNotIn('estado', ['cancelada'])
            ->with('servicio')
            ->groupBy('servicio_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $citasPorGroomer = Cita::selectRaw('groomer_id, COUNT(*) as total')
            ->whereNotIn('estado', ['cancelada'])
            ->with('groomer')
            ->groupBy('groomer_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $ultimasCitas = Cita::with(['mascota', 'servicio', 'groomer'])
            ->orderByDesc('creado_en')
            ->take(5)
            ->get();

        // ── Ranking de rentabilidad ──────────────────────────────────
        $inicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin    = Carbon::create($anio, $mes, 1)->endOfMonth();

        // Servicios más rentables (por ingresos generados)
        $rankingServicios = Cita::selectRaw('servicio_id, COUNT(*) as total_citas, SUM(precio_acordado) as ingresos')
            ->where('estado', 'completada')
            ->whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->with('servicio')
            ->groupBy('servicio_id')
            ->orderByDesc('ingresos')
            ->take(8)
            ->get();

        // Productos más vendidos (por stock vendido = stock_minimo - stock actual no, mejor por pedidos)
        $rankingProductos = Producto::where('activo', true)
            ->orderByDesc('stock_minimo') // proxy: los que más se reponen
            ->take(8)
            ->get();

        // Ingresos por mes (últimos 6 meses)
        $ingresosPorMes = collect(range(5, 0))->map(function ($i) {
            $fecha = now()->subMonths($i);
            return [
                'mes'      => $fecha->locale('es')->monthName,
                'ingresos' => Cita::where('estado', 'completada')
                    ->whereYear('fecha_hora_inicio', $fecha->year)
                    ->whereMonth('fecha_hora_inicio', $fecha->month)
                    ->sum('precio_acordado'),
            ];
        });

        // Tasa de cancelación
        $totalCitas      = Cita::count();
        $tasaCancelacion = $totalCitas > 0 ? round(($citasCanceladas / $totalCitas) * 100, 1) : 0;

        $meses = collect(range(1, 12))->map(fn($m) => [
            'numero' => $m,
            'nombre' => Carbon::create(null, $m)->locale('es')->monthName,
        ]);

        return view('admin.reportes.index', compact(
            'totalClientes', 'citasHoy', 'citasMes', 'totalGroomers',
            'citasCompletadas', 'citasCanceladas', 'productosBajoStock',
            'ingresosMes', 'citasPorEstado', 'topServicios',
            'citasPorGroomer', 'ultimasCitas',
            'rankingServicios', 'rankingProductos', 'ingresosPorMes',
            'tasaCancelacion', 'mes', 'anio', 'meses', 'inicio'
        ));
    }
        // ── Exportar PDF Admin ─────────────────────────────────────────
    public function exportarPDF(Request $request)
    {
        $data = $this->getData($request);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.pdf', $data);
        return $pdf->download('reporte-admin-' . $data['mes'] . '-' . $data['anio'] . '.pdf');
    }

    // ── Exportar Excel Admin ───────────────────────────────────────
    public function exportarExcel(Request $request)
    {
        $mes  = $request->get('mes', now()->month);
        $anio = $request->get('anio', now()->year);
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ReporteAdminExport($mes, $anio),
            'reporte-admin-' . $mes . '-' . $anio . '.xlsx'
        );
    }

    private function getData(Request $request): array
    {
        $hoy   = \Carbon\Carbon::today();
        $mes   = $request->get('mes', $hoy->month);
        $anio  = $request->get('anio', $hoy->year);
        $inicio = \Carbon\Carbon::create($anio, $mes, 1)->startOfMonth();
        $fin    = \Carbon\Carbon::create($anio, $mes, 1)->endOfMonth();

        $totalClientes      = \App\Models\User::whereHas('rol', fn($q) => $q->where('nombre', 'cliente'))->count();
        $citasHoy           = \App\Models\Cita::whereDate('fecha_hora_inicio', $hoy)->whereNotIn('estado', ['cancelada'])->count();
        $citasMes           = \App\Models\Cita::whereMonth('fecha_hora_inicio', $hoy->month)->whereNotIn('estado', ['cancelada'])->count();
        $totalGroomers      = \App\Models\Groomer::where('activo', true)->count();
        $citasCompletadas   = \App\Models\Cita::where('estado', 'completada')->count();
        $citasCanceladas    = \App\Models\Cita::where('estado', 'cancelada')->count();
        $productosBajoStock = \App\Models\Producto::where('activo', true)->whereColumn('stock', '<=', 'stock_minimo')->count();
        $ingresosMes        = \App\Models\Cita::where('estado', 'completada')->whereMonth('fecha_hora_inicio', $hoy->month)->sum('precio_acordado');
        $citasPorEstado     = \App\Models\Cita::selectRaw('estado, COUNT(*) as total')->groupBy('estado')->pluck('total', 'estado');
        $topServicios       = \App\Models\Cita::selectRaw('servicio_id, COUNT(*) as total')->whereNotIn('estado', ['cancelada'])->with('servicio')->groupBy('servicio_id')->orderByDesc('total')->take(5)->get();
        $citasPorGroomer    = \App\Models\Cita::selectRaw('groomer_id, COUNT(*) as total')->whereNotIn('estado', ['cancelada'])->with('groomer')->groupBy('groomer_id')->orderByDesc('total')->take(5)->get();
        $ultimasCitas       = \App\Models\Cita::with(['mascota', 'servicio', 'groomer'])->orderByDesc('creado_en')->take(5)->get();
        $rankingServicios   = \App\Models\Cita::selectRaw('servicio_id, COUNT(*) as total_citas, SUM(precio_acordado) as ingresos')->where('estado', 'completada')->whereBetween('fecha_hora_inicio', [$inicio, $fin])->with('servicio')->groupBy('servicio_id')->orderByDesc('ingresos')->take(8)->get();
        $rankingProductos   = \App\Models\Producto::where('activo', true)->orderByDesc('stock_minimo')->take(8)->get();
        $ingresosPorMes     = collect(range(5, 0))->map(fn($i) => ['mes' => now()->subMonths($i)->locale('es')->monthName, 'ingresos' => \App\Models\Cita::where('estado', 'completada')->whereYear('fecha_hora_inicio', now()->subMonths($i)->year)->whereMonth('fecha_hora_inicio', now()->subMonths($i)->month)->sum('precio_acordado')]);
        $totalCitas         = \App\Models\Cita::count();
        $tasaCancelacion    = $totalCitas > 0 ? round(($citasCanceladas / $totalCitas) * 100, 1) : 0;
        $meses              = collect(range(1, 12))->map(fn($m) => ['numero' => $m, 'nombre' => \Carbon\Carbon::create(null, $m)->locale('es')->monthName]);

        return compact('totalClientes','citasHoy','citasMes','totalGroomers','citasCompletadas','citasCanceladas','productosBajoStock','ingresosMes','citasPorEstado','topServicios','citasPorGroomer','ultimasCitas','rankingServicios','rankingProductos','ingresosPorMes','tasaCancelacion','mes','anio','meses','inicio');
    }

}
