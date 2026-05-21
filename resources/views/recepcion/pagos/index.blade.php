@extends('layouts.dashboard')
@section('page-title', '💳 Pagos registrados')
@section('page-subtitle', 'Historial de todos los pagos del spa')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        {{ session('status') }}
    </div>
@endif

<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden;">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:22px;">💳</span>
        <div style="flex:1;">
            <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Historial de pagos</h3>
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">{{ $pagos->count() }} registro(s)</p>
        </div>
        {{-- Total recaudado --}}
        <div style="background:rgba(255,255,255,0.2); border-radius:10px; padding:8px 16px; text-align:center;">
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">Total recaudado</p>
            <p style="font-size:16px; font-weight:700; color:white; margin:0;">
                Bs. {{ number_format($pagos->where('estado','pagado')->sum('total'), 2) }}
            </p>
        </div>
    </div>

    @if($pagos->isEmpty())
        <div style="padding:40px; text-align:center; color:#a1887f; font-size:14px;">
            <div style="font-size:40px; margin-bottom:12px;">📭</div>
            No hay pagos registrados aún.
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
                        <th style="padding:12px 16px; text-align:center; color:#5d4037; font-weight:700;">Estado</th>
                        <th style="padding:12px 16px; text-align:center; color:#5d4037; font-weight:700;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr style="border-bottom:1px solid #f5f0eb;">
                        <td style="padding:12px 16px; color:#a1887f;">#{{ $pago->id }}</td>
                        <td style="padding:12px 16px;">
                            <p style="font-weight:600; color:#5d4037; margin:0;">{{ $pago->cita->mascota->nombre }}</p>
                            <p style="font-size:12px; color:#a1887f; margin:2px 0 0;">{{ $pago->cita->servicio->nombre }}</p>
                            <p style="font-size:11px; color:#d7ccc8; margin:2px 0 0;">{{ $pago->cita->fecha_hora_inicio->format('d/m/Y H:i') }}</p>
                        </td>
                        <td style="padding:12px 16px; text-align:center;">
                            <span style="font-size:20px;">{{ $pago->metodo_icono }}</span>
                            <p style="font-size:11px; color:#a1887f; margin:2px 0 0;">{{ $pago->metodo_label }}</p>
                        </td>
                        <td style="padding:12px 16px; text-align:right; color:#5d4037;">Bs. {{ number_format($pago->monto, 2) }}</td>
                        <td style="padding:12px 16px; text-align:right; color:#e65100;">
                            @if($pago->descuento > 0) -Bs. {{ number_format($pago->descuento, 2) }} @else — @endif
                        </td>
                        <td style="padding:12px 16px; text-align:right; font-weight:700; color:#ff7043; font-size:15px;">
                            Bs. {{ number_format($pago->total, 2) }}
                        </td>
                        <td style="padding:12px 16px; text-align:center;">
                            @php
                                $estados = [
                                    'pagado'   => ['bg'=>'#e8f5e9','color'=>'#2e7d32','label'=>'✅ Pagado'],
                                    'pendiente'=> ['bg'=>'#fff3e0','color'=>'#e65100','label'=>'⏳ Pendiente'],
                                    'anulado'  => ['bg'=>'#ffebee','color'=>'#c62828','label'=>'❌ Anulado'],
                                ];
                                $e = $estados[$pago->estado] ?? ['bg'=>'#f5f5f5','color'=>'#333','label'=>$pago->estado];
                            @endphp
                            <span style="background:{{ $e['bg'] }}; color:{{ $e['color'] }}; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                                {{ $e['label'] }}
                            </span>
                        </td>
                        <td style="padding:12px 16px; text-align:center;">
                            <div style="display:flex; gap:6px; justify-content:center;">
                                <a href="{{ route('recepcion.pagos.factura', $pago->id) }}"
                                    style="padding:6px 12px; background:#e3f2fd; color:#1565c0; border-radius:8px; font-size:12px; font-weight:600; text-decoration:none;">
                                    🧾 Factura
                                </a>
                                @if($pago->estado === 'pagado')
                                <form method="POST" action="{{ route('recepcion.pagos.anular', $pago->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" onclick="return confirm('¿Anular este pago?')"
                                        style="padding:6px 12px; background:#ffebee; color:#c62828; border:none; border-radius:8px; font-size:12px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                                        ✕ Anular
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
