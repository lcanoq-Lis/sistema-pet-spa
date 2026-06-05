@extends('layouts.dashboard')

@section('page-title', 'Mis Reportes')
@section('page-subtitle', 'Productividad y consumo de insumos')

@section('content')

{{-- Selector de mes y acciones de exportación --}}
<div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:16px 24px; margin-bottom:24px; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
    
    {{-- Formulario de Filtros --}}
    <form method="GET" action="{{ route('groomer.reportes.index') }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap; margin:0;">
        <select name="mes" style="border:1.5px solid #e0e0e0; border-radius:40px; padding:10px 20px; font-size:13px; outline:none; background:#FAFBF7;">
            @foreach($meses as $m)
                <option value="{{ $m['numero'] }}" {{ $mes == $m['numero'] ? 'selected' : '' }}>{{ ucfirst($m['nombre']) }}</option>
            @endforeach
        </select>
        <select name="anio" style="border:1.5px solid #e0e0e0; border-radius:40px; padding:10px 20px; font-size:13px; outline:none; background:#FAFBF7;">
            @foreach(range(now()->year, now()->year - 2) as $a)
                <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>
        <button type="submit" style="background:linear-gradient(135deg, #2E7D32, #1B5E20); color:#fff; font-weight:600; padding:10px 24px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
            <i class="ti ti-filter" style="font-size:14px;"></i> Ver reporte
        </button>
    </form> {{-- <-- AQUÍ ESTABA EL ERROR, YA ESTÁ CERRADO --}}

    {{-- Botones de Exportación --}}
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="{{ route('groomer.reportes.pdf', ['mes'=>$mes,'anio'=>$anio]) }}"
            style="display:inline-flex; align-items:center; gap:6px; background:#C62828; color:#fff; font-weight:600; padding:10px 20px; border-radius:40px; text-decoration:none; font-size:13px;">
            <i class="ti ti-file-type-pdf" style="font-size:15px;"></i> PDF
        </a>
        <a href="{{ route('groomer.reportes.excel', ['mes'=>$mes,'anio'=>$anio]) }}"
            style="display:inline-flex; align-items:center; gap:6px; background:#1B5E20; color:#fff; font-weight:600; padding:8px 20px; border-radius:40px; text-decoration:none; font-size:13px;">
            <i class="ti ti-file-type-xls" style="font-size:15px;"></i> Excel
        </a>
    </div>
</div>

{{-- KPIs --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:24px;">
        <div style="font-size:28px; margin-bottom:8px;">✅</div>
        <div style="font-size:28px; font-weight:800; color:#2E7D32;">{{ $citasCompletadas->count() }}</div>
        <div style="font-size:13px; color:#8A9B8A; margin-top:4px;">Citas completadas</div>
    </div>

    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:24px;">
        <div style="font-size:28px; margin-bottom:8px;">❌</div>
        <div style="font-size:28px; font-weight:800; color:#C62828;">{{ $citasCanceladas->count() }}</div>
        <div style="font-size:13px; color:#8A9B8A; margin-top:4px;">Citas canceladas</div>
    </div>

    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:24px;">
        <div style="font-size:28px; margin-bottom:8px;">💰</div>
        <div style="font-size:28px; font-weight:800; color:#2E7D32;">Bs. {{ number_format($ingresosGenerados, 2) }}</div>
        <div style="font-size:13px; color:#8A9B8A; margin-top:4px;">Ingresos generados</div>
    </div>

    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:24px;">
        <div style="font-size:28px; margin-bottom:8px;">🧴</div>
        <div style="font-size:28px; font-weight:800; color:#1565C0;">{{ $insumosAgrupados->sum('cantidad') }}</div>
        <div style="font-size:13px; color:#8A9B8A; margin-top:4px;">Insumos usados</div>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
    {{-- Historial de citas --}}
    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; overflow:hidden;">
        <div style="padding:20px 24px; border-bottom:1px solid #F0F0EA;">
            <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin:0;">📋 Citas del mes</h3>
            <p style="font-size:12px; color:#8A9B8A; margin:4px 0 0;">{{ ucfirst($inicio->locale('es')->monthName) }} {{ $anio }}</p>
        </div>

        @if($citas->isEmpty())
            <div style="padding:40px; text-align:center; color:#8A9B8A; font-size:14px;">Sin citas este mes</div>
        @else
            <div style="max-height:360px; overflow-y:auto;">
                @foreach($citas as $cita)
                <div style="padding:14px 24px; border-bottom:1px solid #F0F0EA; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="font-weight:600; color:#1A2E1A; font-size:14px;">{{ $cita->mascota->nombre ?? '—' }}</div>
                        <div style="font-size:12px; color:#8A9B8A; margin-top:2px;">{{ $cita->servicio->nombre ?? '—' }} · {{ $cita->fecha_hora_inicio?->format('d/m H:i') }}</div>
                    </div>
                    <span style="font-size:11px; font-weight:700; padding:4px 12px; border-radius:30px;
                        background:{{ $cita->estado === 'completada' ? '#E8F5E9' : ($cita->estado === 'cancelada' ? '#FFEBEE' : '#FFF8E1') }};
                        color:{{ $cita->estado === 'completada' ? '#2E7D32' : ($cita->estado === 'cancelada' ? '#C62828' : '#F57F17') }};">
                        {{ ucfirst($cita->estado) }}
                    </span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Insumos usados --}}
    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; overflow:hidden;">
        <div style="padding:20px 24px; border-bottom:1px solid #F0F0EA;">
            <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin:0;">🧴 Insumos utilizados</h3>
            <p style="font-size:12px; color:#8A9B8A; margin:4px 0 0;">Consumo del mes</p>
        </div>

        @if($insumosAgrupados->isEmpty())
            <div style="padding:40px; text-align:center; color:#8A9B8A; font-size:14px;">Sin insumos registrados</div>
        @else
            <div style="max-height:360px; overflow-y:auto;">
                @foreach($insumosAgrupados as $insumo)
                <div style="padding:14px 24px; border-bottom:1px solid #F0F0EA; display:flex; justify-content:space-between; align-items:center;">
                    <div style="font-weight:600; color:#1A2E1A; font-size:14px;">{{ $insumo['nombre'] }}</div>
                    <div style="font-size:13px; color:#1565C0; font-weight:700;">{{ $insumo['cantidad'] }} {{ $insumo['unidad'] }}</div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection