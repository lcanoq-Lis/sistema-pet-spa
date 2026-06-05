@extends('layouts.dashboard')

@section('page-title', 'Auditoría de Insumos')
@section('page-subtitle', 'Comparación de insumos entregados, usados y devueltos por groomer')

@section('content')

{{-- Selector de mes --}}
<div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:20px 24px; margin-bottom:24px;">
    <form method="GET" action="{{ route('admin.auditoria.insumos') }}" style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
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
    </form>
</div>

@foreach($auditoria as $item)
<div style="background:#fff; border-radius:16px; border:1px solid {{ $item['alerta'] ? '#FFCDD2' : '#e0e0e0' }}; margin-bottom:20px; overflow:hidden;">

    {{-- Header groomer --}}
    <div style="padding:18px 24px; border-bottom:1px solid #F0F0EA; display:flex; justify-content:space-between; align-items:center; background:{{ $item['alerta'] ? '#FFF8F8' : '#FAFBF7' }};">
        <div style="display:flex; align-items:center; gap:12px;">
            <div style="width:40px; height:40px; background:{{ $item['alerta'] ? '#FFEBEE' : '#E8F5E9' }}; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                <i class="ti ti-scissors" style="font-size:18px; color:{{ $item['alerta'] ? '#C62828' : '#2E7D32' }};"></i>
            </div>
            <div>
                <div style="font-weight:700; color:#1A2E1A; font-size:15px;">{{ $item['groomer']->nombre }} {{ $item['groomer']->apellido }}</div>
                <div style="font-size:12px; color:#8A9B8A;">{{ $item['groomer']->usuario?->email }}</div>
            </div>
        </div>
        @if($item['alerta'])
        <span style="background:#FFEBEE; color:#C62828; font-size:12px; font-weight:700; padding:6px 14px; border-radius:30px; display:inline-flex; align-items:center; gap:6px;">
            <i class="ti ti-alert-triangle" style="font-size:13px;"></i> Inconsistencia detectada
        </span>
        @else
        <span style="background:#E8F5E9; color:#2E7D32; font-size:12px; font-weight:700; padding:6px 14px; border-radius:30px; display:inline-flex; align-items:center; gap:6px;">
            <i class="ti ti-circle-check" style="font-size:13px;"></i> Sin anomalías
        </span>
        @endif
    </div>

    {{-- Stats --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:0; border-bottom:1px solid #F0F0EA;">
        @foreach([
            ['label'=>'Entregados', 'value'=>$item['entregados'], 'color'=>'#1565C0', 'bg'=>'#E3F2FD', 'icon'=>'ti-package'],
            ['label'=>'Usados',     'value'=>$item['usados'],     'color'=>'#2E7D32', 'bg'=>'#E8F5E9', 'icon'=>'ti-droplet'],
            ['label'=>'Devueltos',  'value'=>$item['devueltos'],  'color'=>'#F57F17', 'bg'=>'#FFF8E1', 'icon'=>'ti-arrow-back-up'],
            ['label'=>'Diferencia', 'value'=>$item['diferencia'], 'color'=>$item['diferencia'] < 0 ? '#C62828' : '#2E7D32', 'bg'=>$item['diferencia'] < 0 ? '#FFEBEE' : '#E8F5E9', 'icon'=>'ti-math'],
        ] as $stat)
        <div style="padding:20px 24px; text-align:center; border-right:1px solid #F0F0EA;">
            <div style="width:36px; height:36px; background:{{ $stat['bg'] }}; border-radius:10px; display:flex; align-items:center; justify-content:center; margin:0 auto 10px;">
                <i class="ti {{ $stat['icon'] }}" style="font-size:16px; color:{{ $stat['color'] }};"></i>
            </div>
            <div style="font-size:24px; font-weight:800; color:{{ $stat['color'] }};">{{ $stat['value'] }}</div>
            <div style="font-size:12px; color:#8A9B8A; margin-top:4px;">{{ $stat['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Detalle por producto --}}
    @if($item['detalle']->isNotEmpty())
    <div style="padding:16px 24px;">
        <div style="font-size:12px; font-weight:700; color:#8A9B8A; margin-bottom:12px; text-transform:uppercase; letter-spacing:0.5px;">Detalle por producto</div>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px,1fr)); gap:10px;">
            @foreach($item['detalle'] as $prod)
            <div style="background:#FAFBF7; border-radius:10px; padding:12px 14px; border:1px solid #F0F0EA;">
                <div style="font-weight:600; color:#1A2E1A; font-size:13px; margin-bottom:8px;">{{ $prod['nombre'] }}</div>
                <div style="display:flex; gap:12px; font-size:12px;">
                    <span style="color:#2E7D32;"><strong>{{ $prod['usado'] }}</strong> usado</span>
                    <span style="color:#F57F17;"><strong>{{ $prod['devuelto'] }}</strong> devuelto</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div style="padding:20px 24px; text-align:center; color:#8A9B8A; font-size:13px;">Sin insumos registrados este mes</div>
    @endif

</div>
@endforeach

@if($auditoria->isEmpty())
<div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:48px; text-align:center; color:#8A9B8A;">
    No hay groomers activos registrados.
</div>
@endif

@endsection
