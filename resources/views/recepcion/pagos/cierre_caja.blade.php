@extends('layouts.dashboard')
@section('page-title', '🏦 Cierre de Caja')
@section('page-subtitle', 'Resumen diario de cobros')

@section('content')

{{-- Selector de fecha --}}
<form method="GET" action="{{ route('recepcion.pagos.cierre') }}" style="display:flex; gap:10px; align-items:center; margin-bottom:20px;">
    <input type="date" name="fecha" value="{{ $fecha }}" class="form-input" style="width:200px;">
    <button type="submit" class="btn btn-primary">🔍 Consultar</button>
    <a href="{{ route('recepcion.pagos.cierre') }}" class="btn btn-secondary">Hoy</a>
    <button onclick="window.print()" type="button" class="btn btn-secondary">🖨️ Imprimir</button>
</form>

{{-- Resumen por método --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:14px; margin-bottom:20px;">
    <div class="stat-card" style="text-align:center; border-top:4px solid #ff7043;">
        <div style="font-size:28px; margin-bottom:6px;">💵</div>
        <p style="font-size:20px; font-weight:700; color:#5d4037; margin:0;">Bs. {{ number_format($totales['efectivo'], 2) }}</p>
        <p style="font-size:12px; color:#a1887f; margin:4px 0 0;">Efectivo</p>
    </div>
    <div class="stat-card" style="text-align:center; border-top:4px solid #1565c0;">
        <div style="font-size:28px; margin-bottom:6px;">📱</div>
        <p style="font-size:20px; font-weight:700; color:#5d4037; margin:0;">Bs. {{ number_format($totales['qr'], 2) }}</p>
        <p style="font-size:12px; color:#a1887f; margin:4px 0 0;">QR</p>
    </div>
    <div class="stat-card" style="text-align:center; border-top:4px solid #2e7d32;">
        <div style="font-size:28px; margin-bottom:6px;">🏦</div>
        <p style="font-size:20px; font-weight:700; color:#5d4037; margin:0;">Bs. {{ number_format($totales['transferencia'], 2) }}</p>
        <p style="font-size:12px; color:#a1887f; margin:4px 0 0;">Transferencia</p>
    </div>
    <div class="stat-card" style="text-align:center; border-top:4px solid #ff8f00; background:linear-gradient(135deg,#fff8f0,#ffffff);">
        <div style="font-size:28px; margin-bottom:6px;">💰</div>
        <p style="font-size:22px; font-weight:800; color:#ff7043; margin:0;">Bs. {{ number_format($totales['total'], 2) }}</p>
        <p style="font-size:12px; color:#a1887f; margin:4px 0 0;">Total del día ({{ $totales['count'] }} cobro{{ $totales['count'] != 1 ? 's' : '' }})</p>
    </div>
</div>

{{-- Detalle de pagos --}}
<div class="card" style="padding:0; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">📋</span>
        <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">
            Detalle de cobros — {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
        </h3>
    </div>

    @if($pagos->isEmpty())
        <div style="padding:40px; text-align:center; color:#a1887f;">
            <div style="font-size:40px; margin-bottom:12px;">📭</div>
            No hay cobros registrados para esta fecha.
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#f5f0eb;">
                        <th style="padding:12px 16px; text-align:left; color:#5d4037; font-weight:700;">#</th>
                        <th style="padding:12px 16px; text-align:left; color:#5d4037; font-weight:700;">Mascota / Servicio</th>
                        <th style="padding:12px 16px; text-align:center; color:#5d4037; font-weight:700;">Método</th>
                        <th style="padding:12px 16px; text-align:right; color:#5d4037; font-weight:700;">Monto</th>
                        <th style="padding:12px 16px; text-align:right; color:#5d4037; font-weight:700;">Descuento</th>
                        <th style="padding:12px 16px; text-align:right; color:#5d4037; font-weight:700;">Total</th>
                        <th style="padding:12px 16px; text-align:center; color:#5d4037; font-weight:700;">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr style="border-bottom:1px solid #f5f0eb;">
                        <td style="padding:12px 16px; color:#a1887f;">#{{ $pago->id }}</td>
                        <td style="padding:12px 16px;">
                            <p style="font-weight:600; color:#5d4037; margin:0;">{{ $pago->cita->mascota->nombre }}</p>
                            <p style="font-size:12px; color:#a1887f; margin:2px 0 0;">{{ $pago->cita->servicio->nombre }}</p>
                        </td>
                        <td style="padding:12px 16px; text-align:center;">
                            {{ $pago->metodo === 'efectivo' ? '💵' : ($pago->metodo === 'qr' ? '📱' : '🏦') }}
                            <p style="font-size:11px; color:#a1887f; margin:2px 0 0;">{{ $pago->metodo_label }}</p>
                        </td>
                        <td style="padding:12px 16px; text-align:right; color:#5d4037;">Bs. {{ number_format($pago->monto, 2) }}</td>
                        <td style="padding:12px 16px; text-align:right; color:#e65100;">
                            @if($pago->descuento > 0) -Bs. {{ number_format($pago->descuento, 2) }} @else — @endif
                        </td>
                        <td style="padding:12px 16px; text-align:right; font-weight:700; color:#ff7043;">Bs. {{ number_format($pago->total, 2) }}</td>
                        <td style="padding:12px 16px; text-align:center; color:#a1887f;">{{ $pago->creado_en->format('H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#f5f0eb; font-weight:700;">
                        <td colspan="5" style="padding:12px 16px; color:#5d4037; text-align:right;">TOTAL DEL DÍA:</td>
                        <td style="padding:12px 16px; text-align:right; color:#ff7043; font-size:16px;">Bs. {{ number_format($totales['total'], 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>

<style>
@media print {
    .sb-link, .topbar-burger, form, .btn { display: none !important; }
    .sidebar, .topbar { display: none !important; }
    .main { margin-left: 0 !important; }
}
</style>
@endsection
