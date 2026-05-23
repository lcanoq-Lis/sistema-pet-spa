<?php
// app/Http/Controllers/Recepcion/PagoController.php

namespace App\Http\Controllers\Recepcion;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['cita.mascota', 'cita.servicio', 'cita.groomer', 'registradoPor'])
            ->orderBy('creado_en', 'desc')
            ->get();

        return view('recepcion.pagos.index', compact('pagos'));
    }

    public function create($citaId)
    {
        $cita = Cita::with(['mascota', 'servicio', 'groomer'])->findOrFail($citaId);

        if ($cita->pago && $cita->pago->estado === 'pagado') {
            return back()->withErrors(['error' => 'Esta cita ya tiene un pago registrado.']);
        }

        $promociones = \App\Models\Promocion::where('activo', true)
            ->where(function($q) use ($cita) {
                $q->whereNull('servicio_id')
                ->orWhere('servicio_id', $cita->servicio_id);
            })->get();

        return view('recepcion.pagos.create', compact('cita', 'promociones'));
    }

    public function store(Request $request, $citaId)
    {
        $request->validate([
            'metodo'        => 'required|in:efectivo,qr,transferencia',
            'descuento'     => 'nullable|numeric|min:0',
            'referencia'    => 'nullable|string|max:100',
            'observaciones' => 'nullable|string|max:300',
        ]);

        $cita     = Cita::with('servicio')->findOrFail($citaId);
        $monto    = $cita->precio_acordado;
        $descuento = $request->descuento ?? 0;
        $total    = max(0, $monto - $descuento);

        Pago::updateOrCreate(
            ['cita_id' => $citaId],
            [
                'metodo'         => $request->metodo,
                'monto'          => $monto,
                'descuento'      => $descuento,
                'total'          => $total,
                'referencia'     => $request->referencia,
                'observaciones'  => $request->observaciones,
                'estado'         => 'pagado',
                'registrado_por' => Auth::id(),
            ]
        );

        return redirect()->route('recepcion.pagos.index')
            ->with('status', "✅ Pago de Bs. {$total} registrado correctamente.");
    }

    public function factura($pagoId)
    {
        $pago = Pago::with(['cita.mascota', 'cita.servicio', 'cita.groomer', 'registradoPor'])
            ->findOrFail($pagoId);

        return view('recepcion.pagos.factura', compact('pago'));
    }

    public function anular($pagoId)
    {
        $pago = Pago::findOrFail($pagoId);
        $pago->estado = 'anulado';
        $pago->save();

        return back()->with('status', 'Pago anulado correctamente.');
    }
    public function calcularPromocion(Request $request)
{
    $request->validate([
        'promocion_id' => 'required|exists:promociones,id',
        'monto'        => 'required|numeric|min:0',
        'cita_id'      => 'nullable|exists:citas,id',
    ]);

    $promo = \App\Models\Promocion::findOrFail($request->promocion_id);

    if (!$promo->estaVigente()) {
        return response()->json(['error' => 'La promoción no está vigente.'], 422);
    }

    // Validar cliente frecuente
    if ($promo->tipo === 'cliente_frecuente' && $request->cita_id) {
        $cita = \App\Models\Cita::with('mascota')->find($request->cita_id);
        if ($cita) {
            $totalCitas = \App\Models\Cita::where('creado_por_usuario_id', $cita->creado_por_usuario_id)
                ->where('estado', 'completada')->count();
            if ($totalCitas < $promo->min_citas) {
                return response()->json([
                    'error' => "El cliente necesita {$promo->min_citas} citas completadas. Tiene {$totalCitas}."
                ], 422);
            }
        }
    }

    $descuento = $promo->calcularDescuento($request->monto);
    $total     = max(0, $request->monto - $descuento);

    return response()->json([
        'descuento' => $descuento,
        'total'     => $total,
        'label'     => $promo->tipo_label,
    ]);
}
}
