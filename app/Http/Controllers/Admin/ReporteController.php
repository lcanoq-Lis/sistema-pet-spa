<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Groomer;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        // KPIs principales
        $totalClientes    = User::whereHas('rol', fn($q) => $q->where('nombre', 'cliente'))->count();
        $citasHoy         = Cita::whereDate('fecha_hora_inicio', $hoy)->whereNotIn('estado', ['cancelada'])->count();
        $citasMes         = Cita::whereMonth('fecha_hora_inicio', $hoy->month)->whereNotIn('estado', ['cancelada'])->count();
        $totalGroomers    = Groomer::where('activo', true)->count();
        $citasCompletadas = Cita::where('estado', 'completada')->count();
        $citasCanceladas  = Cita::where('estado', 'cancelada')->count();
        $productosBajoStock = Producto::where('activo', true)->whereColumn('stock', '<=', 'stock_minimo')->count();

        // Ingresos estimados del mes
        $ingresosMes = Cita::where('estado', 'completada')
            ->whereMonth('fecha_hora_inicio', $hoy->month)
            ->sum('precio_acordado');

        // Citas por estado
        $citasPorEstado = Cita::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // Top servicios
        $topServicios = Cita::selectRaw('servicio_id, COUNT(*) as total')
            ->whereNotIn('estado', ['cancelada'])
            ->with('servicio')
            ->groupBy('servicio_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Citas por groomer
        $citasPorGroomer = Cita::selectRaw('groomer_id, COUNT(*) as total')
            ->whereNotIn('estado', ['cancelada'])
            ->with('groomer')
            ->groupBy('groomer_id')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Últimas citas
        $ultimasCitas = Cita::with(['mascota', 'servicio', 'groomer'])
            ->orderByDesc('creado_en')
            ->take(5)
            ->get();

        return view('admin.reportes.index', compact(
            'totalClientes', 'citasHoy', 'citasMes', 'totalGroomers',
            'citasCompletadas', 'citasCanceladas', 'productosBajoStock',
            'ingresosMes', 'citasPorEstado', 'topServicios',
            'citasPorGroomer', 'ultimasCitas'
        ));
    }
}