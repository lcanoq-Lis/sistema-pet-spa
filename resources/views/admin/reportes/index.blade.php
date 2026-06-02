@extends('layouts.dashboard')

@section('page-title', 'Reportes')
@section('page-subtitle', 'Dashboard ejecutivo y estadísticas')

@section('content')

{{-- KPIs principales --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:16px; margin-bottom:24px;">

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-users" style="font-size:24px; color:#2E7D32;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#2E7D32; margin:0;">{{ $totalClientes }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Clientes registrados</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E3F2FD; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-calendar-event" style="font-size:24px; color:#1565C0;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#1565C0; margin:0;">{{ $citasHoy }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Citas hoy</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-calendar-month" style="font-size:24px; color:#2E7D32;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#2E7D32; margin:0;">{{ $citasMes }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Citas este mes</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#F3E5F5; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-scissors" style="font-size:24px; color:#6A1B9A;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#6A1B9A; margin:0;">{{ $totalGroomers }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Groomers activos</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-circle-check" style="font-size:24px; color:#2E7D32;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#2E7D32; margin:0;">{{ $citasCompletadas }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Citas completadas</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#FFEBEE; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-circle-x" style="font-size:24px; color:#C62828;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#C62828; margin:0;">{{ $citasCanceladas }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Citas canceladas</p>
    </div>

    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#FFF3E0; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-package" style="font-size:24px; color:#E65100;"></i>
        </div>
        <p style="font-size:28px; font-weight:800; color:#E65100; margin:0;">{{ $productosBajoStock }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin-top:6px;">Productos bajo stock</p>
    </div>

    <div class="stat-card" style="text-align:center; background:linear-gradient(135deg,#FF7043,#FF8F00); color:white;">
        <div style="width:48px; height:48px; background:rgba(255,255,255,0.2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
            <i class="ti ti-coin" style="font-size:24px; color:white;"></i>
        </div>
        <p style="font-size:26px; font-weight:800; margin:0;">Bs. {{ number_format($ingresosMes, 2) }}</p>
        <p style="font-size:12px; opacity:0.85; margin-top:6px;">Ingresos este mes</p>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">

    {{-- Citas por estado --}}
    <div class="stat-card" style="border-radius:20px;">
        <h3 style="font-size:14px; font-weight:700; color:#5D4037; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-chart-pie" style="font-size:18px; color:#FF7043;"></i> Citas por estado
        </h3>
        @php
            $colores = [
                'agendada'    => '#E65100',
                'confirmada'  => '#2E7D32',
                'en_progreso' => '#1565C0',
                'completada'  => '#6A1B9A',
                'cancelada'   => '#C62828',
                'no_asistio'  => '#757575',
            ];
            $total = $citasPorEstado->sum();
        @endphp
        @foreach($citasPorEstado as $estado => $cantidad)
        <div style="margin-bottom:14px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
                <span style="font-size:12px; color:#5D4037; font-weight:600; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-circle" style="font-size:10px; color:{{ $colores[$estado] ?? '#FF7043' }};"></i>
                    {{ ucfirst(str_replace('_', ' ', $estado)) }}
                </span>
                <span style="font-size:13px; font-weight:700; color:#5D4037;">{{ $cantidad }}</span>
            </div>
            <div style="background:#F5F0EB; border-radius:6px; height:8px; overflow:hidden;">
                <div style="background:{{ $colores[$estado] ?? '#FF7043' }}; height:100%; width:{{ $total > 0 ? ($cantidad/$total)*100 : 0 }}%; border-radius:6px;"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Top servicios --}}
    <div class="stat-card" style="border-radius:20px;">
        <h3 style="font-size:14px; font-weight:700; color:#5D4037; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-trophy" style="font-size:18px; color:#FF8F00;"></i> Top servicios
        </h3>
        @forelse($topServicios as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #F5F0EB;">
            <span style="font-size:13px; color:#5D4037; font-weight:600; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-scissors" style="font-size:14px; color:#FF7043;"></i>
                {{ $item->servicio?->nombre ?? 'Sin servicio' }}
            </span>
            <span style="background:#FFF3E0; color:#E65100; padding:4px 14px; border-radius:40px; font-size:11px; font-weight:700;">
                {{ $item->total }} citas
            </span>
        </div>
        @empty
        <div style="text-align:center; padding:30px;">
            <i class="ti ti-chart-bar-off" style="font-size:36px; color:#D7CCC8;"></i>
            <p style="color:#A1887F; font-size:13px; margin-top:12px;">No hay datos aún.</p>
        </div>
        @endforelse
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

    {{-- Citas por groomer --}}
    <div class="stat-card" style="border-radius:20px;">
        <h3 style="font-size:14px; font-weight:700; color:#5D4037; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-user-check" style="font-size:18px; color:#6A1B9A;"></i> Citas por groomer
        </h3>
        @forelse($citasPorGroomer as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #F5F0EB;">
            <span style="font-size:13px; color:#5D4037; font-weight:600; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-user" style="font-size:14px; color:#6A1B9A;"></i>
                {{ $item->groomer?->nombre ?? 'Sin groomer' }}
            </span>
            <span style="background:#E8F5E9; color:#2E7D32; padding:4px 14px; border-radius:40px; font-size:11px; font-weight:700;">
                {{ $item->total }} citas
            </span>
        </div>
        @empty
        <div style="text-align:center; padding:30px;">
            <i class="ti ti-user-off" style="font-size:36px; color:#D7CCC8;"></i>
            <p style="color:#A1887F; font-size:13px; margin-top:12px;">No hay datos aún.</p>
        </div>
        @endforelse
    </div>

    {{-- Últimas citas --}}
    <div class="stat-card" style="border-radius:20px;">
        <h3 style="font-size:14px; font-weight:700; color:#5D4037; margin-bottom:20px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-clock" style="font-size:18px; color:#1565C0;"></i> Últimas citas
        </h3>
        @forelse($ultimasCitas as $cita)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:12px 0; border-bottom:1px solid #F5F0EB;">
            <div>
                <p style="font-size:13px; font-weight:700; color:#5D4037; margin:0; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-dog" style="font-size:14px; color:#FF7043;"></i>
                    {{ $cita->mascota?->nombre ?? '—' }}
                </p>
                <p style="font-size:11px; color:#A1887F; margin:4px 0 0;">
                    <i class="ti ti-scissors" style="font-size:10px;"></i> {{ $cita->servicio?->nombre ?? '—' }}
                </p>
            </div>
            <div style="text-align:right;">
                <p style="font-size:11px; color:#A1887F; margin:0 0 6px 0; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-calendar" style="font-size:10px;"></i> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                </p>
                @php
                    $colores = [
                        'agendada'    => ['bg'=>'#FFF3E0','color'=>'#E65100','icon'=>'ti-clock'],
                        'confirmada'  => ['bg'=>'#E8F5E9','color'=>'#2E7D32','icon'=>'ti-circle-check'],
                        'completada'  => ['bg'=>'#F3E5F5','color'=>'#6A1B9A','icon'=>'ti-check'],
                        'cancelada'   => ['bg'=>'#FFEBEE','color'=>'#C62828','icon'=>'ti-circle-x'],
                        'en_progreso' => ['bg'=>'#E3F2FD','color'=>'#1565C0','icon'=>'ti-refresh'],
                    ];
                    $c = $colores[$cita->estado] ?? ['bg'=>'#F5F5F5','color'=>'#757575','icon'=>'ti-circle'];
                @endphp
                <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:4px 12px; border-radius:40px; font-size:10px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                    <i class="ti {{ $c['icon'] }}" style="font-size:10px;"></i>
                    {{ ucfirst(str_replace('_', ' ', $cita->estado)) }}
                </span>
            </div>
        </div>
        @empty
        <div style="text-align:center; padding:30px;">
            <i class="ti ti-calendar-off" style="font-size:36px; color:#D7CCC8;"></i>
            <p style="color:#A1887F; font-size:13px; margin-top:12px;">No hay citas aún.</p>
        </div>
        @endforelse
    </div>
</div>

@endsection