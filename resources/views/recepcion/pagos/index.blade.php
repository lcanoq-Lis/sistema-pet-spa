@extends('layouts.dashboard')
@section('page-title', 'Pagos registrados')
@section('page-subtitle', 'Historial de todos los pagos del spa')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); padding:18px 24px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
        <div style="width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-cash" style="font-size:22px; color:#fff;"></i>
        </div>
        <div style="flex:1;">
            <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Historial de pagos</h3>
            <p style="font-size:11px; color:#C8E6C9; margin:0;">{{ $pagos->count() }} registro(s)</p>
        </div>
        <div style="background:rgba(255,255,255,0.12); border-radius:14px; padding:10px 20px; text-align:center;">
            <p style="font-size:10px; font-weight:600; color:#C8E6C9; text-transform:uppercase; margin:0;">Total recaudado</p>
            <p style="font-size:18px; font-weight:800; color:#fff; margin:0;">
                Bs. {{ number_format($pagos->where('estado','pagado')->sum('total'), 2) }}
            </p>
        </div>
    </div>

    @if($pagos->isEmpty())
        <div style="padding:56px 24px; text-align:center;">
            <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <i class="ti ti-receipt-off" style="font-size:28px; color:#8A9B8A;"></i>
            </div>
            <p style="color:#8A9B8A; font-size:14px; margin:0;">No hay pagos registrados aún.</p>
        </div>
    @else
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px; min-width:900px;">
                <thead>
                    <tr style="background:#F5F5F0;">
                        <th style="padding:14px 20px; text-align:left; color:#5D6E5D; font-weight:700;">#</th>
                        <th style="padding:14px 20px; text-align:left; color:#5D6E5D; font-weight:700;">Mascota / Servicio</th>
                        <th style="padding:14px 20px; text-align:center; color:#5D6E5D; font-weight:700;">Método</th>
                        <th style="padding:14px 20px; text-align:right; color:#5D6E5D; font-weight:700;">Monto</th>
                        <th style="padding:14px 20px; text-align:right; color:#5D6E5D; font-weight:700;">Descuento</th>
                        <th style="padding:14px 20px; text-align:right; color:#5D6E5D; font-weight:700;">Total</th>
                        <th style="padding:14px 20px; text-align:center; color:#5D6E5D; font-weight:700;">Estado</th>
                        <th style="padding:14px 20px; text-align:center; color:#5D6E5D; font-weight:700;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pagos as $pago)
                    <tr style="border-bottom:1px solid #F0F0EA;">
                        <td style="padding:14px 20px; color:#8A9B8A; font-weight:600;">#{{ $pago->id }}</td>
                        <td style="padding:14px 20px;">
                            <p style="font-weight:700; color:#1A2E1A; margin:0;">{{ $pago->cita->mascota->nombre }}</p>
                            <p style="font-size:11px; color:#8A9B8A; margin:3px 0 0;">{{ $pago->cita->servicio->nombre }}</p>
                            <p style="font-size:10px; color:#B0B0A0; margin:2px 0 0; display:flex; align-items:center; gap:4px;">
                                <i class="ti ti-calendar" style="font-size:10px;"></i> {{ $pago->cita->fecha_hora_inicio->format('d/m/Y H:i') }}
                            </p>
                        </td>
                        <td style="padding:14px 20px; text-align:center;">
                            <div style="display:inline-flex; flex-direction:column; align-items:center;">
                                <div style="width:36px; height:36px; background:#F5F5F0; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:4px;">
                                    @if($pago->metodo === 'efectivo')
                                        <i class="ti ti-cash" style="font-size:18px; color:#FF7043;"></i>
                                    @elseif($pago->metodo === 'qr')
                                        <i class="ti ti-qrcode" style="font-size:18px; color:#1565C0;"></i>
                                    @else
                                        <i class="ti ti-transfer" style="font-size:18px; color:#2E7D32;"></i>
                                    @endif
                                </div>
                                <span style="font-size:10px; font-weight:600; color:#8A9B8A;">{{ $pago->metodo_label }}</span>
                            </div>
                        </td>
                        <td style="padding:14px 20px; text-align:right; color:#1A2E1A;">Bs. {{ number_format($pago->monto, 2) }}</td>
                        <td style="padding:14px 20px; text-align:right; color:#E65100;">
                            @if($pago->descuento > 0) 
                                <span style="display:inline-flex; align-items:center; gap:2px;"><i class="ti ti-discount" style="font-size:10px;"></i> -Bs. {{ number_format($pago->descuento, 2) }}</span>
                            @else 
                                — 
                            @endif
                        </td>
                        <td style="padding:14px 20px; text-align:right; font-weight:800; color:#FF7043; font-size:15px;">
                            Bs. {{ number_format($pago->total, 2) }}
                        </td>
                        <td style="padding:14px 20px; text-align:center;">
                            @php
                                $estados = [
                                    'pagado'   => ['bg'=>'#E8F5E9','color'=>'#2E7D32','icon'=>'ti-check','label'=>'Pagado'],
                                    'pendiente'=> ['bg'=>'#FFF8E1','color'=>'#F57F17','icon'=>'ti-clock','label'=>'Pendiente'],
                                    'anulado'  => ['bg'=>'#FFEBEE','color'=>'#C62828','icon'=>'ti-x','label'=>'Anulado'],
                                ];
                                $e = $estados[$pago->estado] ?? ['bg'=>'#F5F5F0','color'=>'#8A9B8A','icon'=>'ti-help','label'=>$pago->estado];
                            @endphp
                            <span style="background:{{ $e['bg'] }}; color:{{ $e['color'] }}; padding:5px 12px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                                <i class="ti {{ $e['icon'] }}" style="font-size:11px;"></i> {{ $e['label'] }}
                            </span>
                        </td>
                        <td style="padding:14px 20px; text-align:center;">
                            <div style="display:flex; gap:8px; justify-content:center;">
                                <a href="{{ route('recepcion.pagos.factura', $pago->id) }}"
                                    style="padding:6px 14px; background:#E3F2FD; color:#1565C0; border-radius:10px; font-size:11px; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                    <i class="ti ti-file-text" style="font-size:12px;"></i> Factura
                                </a>
                                @if($pago->estado === 'pagado')
                                <form method="POST" action="{{ route('recepcion.pagos.anular', $pago->id) }}">
                                    @csrf @method('PATCH')
                                    <button type="submit" onclick="return confirm('¿Anular este pago? Esta acción no se puede deshacer.')"
                                        style="padding:6px 14px; background:#FFEBEE; color:#C62828; border:none; border-radius:10px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
                                        <i class="ti ti-x" style="font-size:12px;"></i> Anular
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
