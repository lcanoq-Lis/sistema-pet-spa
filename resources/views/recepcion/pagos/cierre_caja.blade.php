@extends('layouts.dashboard')
@section('page-title', 'Cierre de Caja')
@section('page-subtitle', 'Resumen diario de cobros')

@section('content')

{{-- Selector de fecha --}}
<form method="GET" action="{{ route('recepcion.pagos.cierre') }}" style="display:flex; gap:10px; align-items:center; margin-bottom:24px; flex-wrap:wrap;">
    <div style="position:relative;">
        <i class="ti ti-calendar" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:14px; color:#8A9B8A;"></i>
        <input type="date" name="fecha" value="{{ $fecha }}" style="width:200px; border:1.5px solid #e0e0e0; border-radius:12px; padding:10px 12px 10px 36px; font-size:13px; outline:none;">
    </div>
    <button type="submit" style="background:#1B5E20; border:none; border-radius:12px; padding:10px 20px; font-size:12px; font-weight:600; color:#fff; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
        <i class="ti ti-search" style="font-size:14px;"></i> Consultar
    </button>
    <a href="{{ route('recepcion.pagos.cierre') }}" style="background:#fff; border:1.5px solid #e0e0e0; border-radius:12px; padding:10px 20px; font-size:12px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
        <i class="ti ti-calendar-today" style="font-size:14px;"></i> Hoy
    </a>
    <button onclick="window.print()" type="button" style="background:#fff; border:1.5px solid #e0e0e0; border-radius:12px; padding:10px 20px; font-size:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:inline-flex; align-items:center; gap:6px;">
        <i class="ti ti-printer" style="font-size:14px;"></i> Imprimir
    </button>
</form>

{{-- Resumen por método --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:20px 16px; border-top:4px solid #FF7043;">
        <div style="width:48px; height:48px; background:#FFF3E0; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
            <i class="ti ti-cash" style="font-size:24px; color:#FF7043;"></i>
        </div>
        <p style="font-size:24px; font-weight:800; color:#1A2E1A; margin:0;">Bs. {{ number_format($totales['efectivo'], 2) }}</p>
        <p style="font-size:12px; color:#8A9B8A; margin:6px 0 0;">Efectivo</p>
    </div>
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:20px 16px; border-top:4px solid #1565C0;">
        <div style="width:48px; height:48px; background:#E3F2FD; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
            <i class="ti ti-qrcode" style="font-size:24px; color:#1565C0;"></i>
        </div>
        <p style="font-size:24px; font-weight:800; color:#1A2E1A; margin:0;">Bs. {{ number_format($totales['qr'], 2) }}</p>
        <p style="font-size:12px; color:#8A9B8A; margin:6px 0 0;">QR</p>
    </div>
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:20px 16px; border-top:4px solid #2E7D32;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
            <i class="ti ti-transfer" style="font-size:24px; color:#2E7D32;"></i>
        </div>
        <p style="font-size:24px; font-weight:800; color:#1A2E1A; margin:0;">Bs. {{ number_format($totales['transferencia'], 2) }}</p>
        <p style="font-size:12px; color:#8A9B8A; margin:6px 0 0;">Transferencia</p>
    </div>
    <div style="background:linear-gradient(135deg, #FFF8F0, #fff); border-radius:20px; border:0.5px solid #FFE0B2; text-align:center; padding:20px 16px; border-top:4px solid #F57F17;">
        <div style="width:48px; height:48px; background:#FFF3E0; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
            <i class="ti ti-calculator" style="font-size:24px; color:#F57F17;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#F57F17; margin:0;">Bs. {{ number_format($totales['total'], 2) }}</p>
        <p style="font-size:12px; color:#8A9B8A; margin:6px 0 0;">Total del día ({{ $totales['count'] }} cobro{{ $totales['count'] != 1 ? 's' : '' }})</p>
    </div>
</div>

{{-- Detalle de pagos --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); padding:16px 24px; display:flex; align-items:center; gap:12px;">
        <i class="ti ti-list-details" style="font-size:20px; color:#fff;"></i>
        <h3 style="font-size:14px; font-weight:700; color:#fff; margin:0;">
            Detalle de cobros — {{ \Carbon\Carbon::parse($fecha)->locale('es')->isoFormat('dddd D [de] MMMM, YYYY') }}
        </h3>
    </div>

    @if($pagos->isEmpty())
        <div style="padding:48px; text-align:center;">
            <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <i class="ti ti-receipt-off" style="font-size:28px; color:#8A9B8A;"></i>
            </div>
            <p style="color:#8A9B8A; font-size:14px; margin:0;">No hay cobros registrados para esta fecha.</p>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="background:#F5F5F0;">
                        <th style="padding:14px 20px; text-align:left; color:#5D6E5D; font-weight:700;">#</th>
                        <th style="padding:14px 20px; text-align:left; color:#5D6E5D; font-weight:700;">Mascota / Servicio</th>
                        <th style="padding:14px 20px; text-align:center; color:#5D6E5D; font-weight:700;">Método</th>
                        <th style="padding:14px 20px; text-align:right; color:#5D6E5D; font-weight:700;">Monto</th>
                        <th style="padding:14px 20px; text-align:right; color:#5D6E5D; font-weight:700;">Descuento</th>
                        <th style="padding:14px 20px; text-align:right; color:#5D6E5D; font-weight:700;">Total</th>
                        <th style="padding:14px 20px; text-align:center; color:#5D6E5D; font-weight:700;">Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr style="border-bottom:1px solid #F0F0EA;">
                        <td style="padding:14px 20px; color:#8A9B8A;">#{{ $pago->id }}</td>
                        <td style="padding:14px 20px;">
                            <p style="font-weight:700; color:#1A2E1A; margin:0;">{{ $pago->cita->mascota->nombre }}</p>
                            <p style="font-size:11px; color:#8A9B8A; margin:3px 0 0;">{{ $pago->cita->servicio->nombre }}</p>
                        </td>
                        <td style="padding:14px 20px; text-align:center;">
                            <div style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; background:#F5F5F0;">
                                <i class="ti {{ $pago->metodo === 'efectivo' ? 'ti-cash' : ($pago->metodo === 'qr' ? 'ti-qrcode' : 'ti-transfer') }}" style="font-size:14px;"></i>
                                <span style="font-size:11px; font-weight:600;">{{ $pago->metodo_label }}</span>
                            </div>
                        </td>
                        <td style="padding:14px 20px; text-align:right; color:#1A2E1A;">Bs. {{ number_format($pago->monto, 2) }}</td>
                        <td style="padding:14px 20px; text-align:right; color:#E65100;">
                            @if($pago->descuento > 0) -Bs. {{ number_format($pago->descuento, 2) }} @else — @endif
                        </td>
                        <td style="padding:14px 20px; text-align:right; font-weight:800; color:#FF7043;">Bs. {{ number_format($pago->total, 2) }}</td>
                        <td style="padding:14px 20px; text-align:center; color:#8A9B8A;">{{ $pago->creado_en->format('H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background:#F5F5F0; font-weight:700;">
                        <td colspan="5" style="padding:14px 20px; color:#1A2E1A; text-align:right;">TOTAL DEL DÍA:</td>
                        <td style="padding:14px 20px; text-align:right; color:#FF7043; font-size:18px;">Bs. {{ number_format($totales['total'], 2) }}</td>
                        <td style="padding:14px 20px;"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
</div>

<style>
@media print {
    .sb-link, .topbar-burger, form, button, a, .btn { display: none !important; }
    .sidebar, .topbar { display: none !important; }
    .main { margin-left: 0 !important; }
    body { background: white; }
    .stat-card { box-shadow: none; border: 1px solid #ddd; }
}
</style>
@endsection
