@extends('layouts.dashboard')

@section('page-title', '📊 Reportes')
@section('page-subtitle', 'Dashboard ejecutivo y estadísticas')

@section('content')

{{-- KPIs principales --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:16px; margin-bottom:24px;">

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">👥</div>
        <p style="font-size:32px; font-weight:800; color:#ff7043;">{{ $totalClientes }}</p>
        <p style="font-size:13px; color:#a1887f;">Clientes registrados</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">📅</div>
        <p style="font-size:32px; font-weight:800; color:#1565c0;">{{ $citasHoy }}</p>
        <p style="font-size:13px; color:#a1887f;">Citas hoy</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">📆</div>
        <p style="font-size:32px; font-weight:800; color:#2e7d32;">{{ $citasMes }}</p>
        <p style="font-size:13px; color:#a1887f;">Citas este mes</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">✂️</div>
        <p style="font-size:32px; font-weight:800; color:#6a1b9a;">{{ $totalGroomers }}</p>
        <p style="font-size:13px; color:#a1887f;">Groomers activos</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">🎉</div>
        <p style="font-size:32px; font-weight:800; color:#2e7d32;">{{ $citasCompletadas }}</p>
        <p style="font-size:13px; color:#a1887f;">Citas completadas</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">❌</div>
        <p style="font-size:32px; font-weight:800; color:#c62828;">{{ $citasCanceladas }}</p>
        <p style="font-size:13px; color:#a1887f;">Citas canceladas</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="font-size:36px; margin-bottom:8px;">📦</div>
        <p style="font-size:32px; font-weight:800; color:#e65100;">{{ $productosBajoStock }}</p>
        <p style="font-size:13px; color:#a1887f;">Productos bajo stock</p>
    </div>

    <div class="stat-card" style="text-align:center; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white;">
        <div style="font-size:36px; margin-bottom:8px;">💰</div>
        <p style="font-size:28px; font-weight:800;">Bs. {{ number_format($ingresosMes, 2) }}</p>
        <p style="font-size:13px; opacity:0.9;">Ingresos este mes</p>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">

    {{-- Citas por estado --}}
    <div class="stat-card">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">📊 Citas por estado</h3>
        @php
            $colores = [
                'agendada'    => '#e65100',
                'confirmada'  => '#2e7d32',
                'en_progreso' => '#1565c0',
                'completada'  => '#6a1b9a',
                'cancelada'   => '#c62828',
                'no_asistio'  => '#757575',
            ];
            $total = $citasPorEstado->sum();
        @endphp
        @foreach($citasPorEstado as $estado => $cantidad)
        <div style="margin-bottom:12px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                <span style="font-size:13px; color:#5d4037; font-weight:600;">{{ ucfirst(str_replace('_', ' ', $estado)) }}</span>
                <span style="font-size:13px; color:#a1887f;">{{ $cantidad }}</span>
            </div>
            <div style="background:#f5f0eb; border-radius:10px; height:8px; overflow:hidden;">
                <div style="background:{{ $colores[$estado] ?? '#ff7043' }}; height:100%; width:{{ $total > 0 ? ($cantidad/$total)*100 : 0 }}%; border-radius:10px;"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Top servicios --}}
    <div class="stat-card">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">🏆 Top servicios</h3>
        @forelse($topServicios as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f5f0eb;">
            <span style="font-size:13px; color:#5d4037; font-weight:600;">{{ $item->servicio?->nombre ?? 'Sin servicio' }}</span>
            <span style="background:#fff3e0; color:#ff7043; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                {{ $item->total }} citas
            </span>
        </div>
        @empty
        <p style="color:#a1887f; font-size:13px;">No hay datos aún.</p>
        @endforelse
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

    {{-- Citas por groomer --}}
    <div class="stat-card">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">✂️ Citas por groomer</h3>
        @forelse($citasPorGroomer as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f5f0eb;">
            <span style="font-size:13px; color:#5d4037; font-weight:600;">{{ $item->groomer?->nombre ?? 'Sin groomer' }}</span>
            <span style="background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">
                {{ $item->total }} citas
            </span>
        </div>
        @empty
        <p style="color:#a1887f; font-size:13px;">No hay datos aún.</p>
        @endforelse
    </div>

    {{-- Últimas citas --}}
    <div class="stat-card">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">🕐 Últimas citas</h3>
        @forelse($ultimasCitas as $cita)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f5f0eb;">
            <div>
                <p style="font-size:13px; font-weight:600; color:#5d4037;">{{ $cita->mascota?->nombre ?? '—' }}</p>
                <p style="font-size:11px; color:#a1887f;">{{ $cita->servicio?->nombre ?? '—' }}</p>
            </div>
            <div style="text-align:right;">
                <p style="font-size:12px; color:#5d4037;">{{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
                @php
                    $colores = [
                        'agendada'    => ['bg'=>'#fff3e0','color'=>'#e65100'],
                        'confirmada'  => ['bg'=>'#e8f5e9','color'=>'#2e7d32'],
                        'completada'  => ['bg'=>'#f3e5f5','color'=>'#6a1b9a'],
                        'cancelada'   => ['bg'=>'#ffebee','color'=>'#c62828'],
                        'en_progreso' => ['bg'=>'#e3f2fd','color'=>'#1565c0'],
                    ];
                    $c = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5','color'=>'#333'];
                @endphp
                <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">
                    {{ ucfirst($cita->estado) }}
                </span>
            </div>
        </div>
        @empty
        <p style="color:#a1887f; font-size:13px;">No hay citas aún.</p>
        @endforelse
    </div>
</div>

@endsection