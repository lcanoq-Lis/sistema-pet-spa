<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\PuntoCliente;
use App\Models\EvolucionMascota;
use Illuminate\Support\Facades\Auth;

class ReporteClienteController extends Controller
{
    public function index()
    {
        $cliente = Cliente::where('usuario_id', Auth::id())->firstOrFail();

        // Historial de citas completas
        $historial = Cita::whereHas('mascota', function ($q) use ($cliente) {
                $q->whereHas('duenos', fn($q2) => $q2->where('cliente_id', $cliente->id));
            })
            ->with(['mascota', 'servicio', 'groomer', 'pago'])
            ->whereIn('estado', ['completada', 'cancelada', 'no_asistio'])
            ->orderByDesc('fecha_hora_inicio')
            ->get();

        // Mascotas del cliente
        $mascotas = $cliente->mascotas()->where('activo', true)->with('vacunas')->get();

        // Puntos acumulados
        $puntosTotales = PuntoCliente::where('cliente_id', Auth::id())->sum('puntos');
        $movimientosPuntos = PuntoCliente::where('cliente_id', Auth::id())
            ->with('cita.servicio')
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Evolución de mascotas (galería)
        $mascotaIds = $mascotas->pluck('id');
        $evoluciones = EvolucionMascota::whereIn('mascota_id', $mascotaIds)
            ->with('mascota')
            ->orderByDesc('fecha')
            ->get();

        // Stats rápidas
        $totalCitas       = $historial->where('estado', 'completada')->count();
        $totalGastado     = $historial->where('estado', 'completada')->sum(fn($c) => $c->pago?->total ?? $c->precio_acordado);
        $servicioFavorito = $historial->where('estado', 'completada')
            ->groupBy('servicio_id')
            ->map->count()
            ->sortDesc()
            ->keys()
            ->first();
        $servicioFavoritoNombre = $historial->where('servicio_id', $servicioFavorito)->first()?->servicio?->nombre ?? '—';

        return view('cliente.reportes.index', compact(
            'cliente', 'historial', 'mascotas', 'puntosTotales',
            'movimientosPuntos', 'evoluciones', 'totalCitas',
            'totalGastado', 'servicioFavoritoNombre'
        ));
    }
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
