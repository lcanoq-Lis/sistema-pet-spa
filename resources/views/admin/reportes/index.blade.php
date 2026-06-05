@extends('layouts.dashboard')

@section('page-title', 'Reportes')
@section('page-subtitle', 'Dashboard ejecutivo y estadísticas')

@section('content')

{{-- Selector de mes para ranking --}}
<div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:16px 24px; margin-bottom:24px; display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
    <span style="font-size:13px; font-weight:600; color:#8A9B8A;">Ranking del período:</span>
    <form method="GET" action="{{ route('admin.reportes.index') }}" style="display:flex; gap:10px; align-items:center;">
        <select name="mes" style="border:1.5px solid #e0e0e0; border-radius:40px; padding:8px 16px; font-size:13px; outline:none; background:#FAFBF7;">
            @foreach($meses as $m)
                <option value="{{ $m['numero'] }}" {{ $mes == $m['numero'] ? 'selected' : '' }}>{{ ucfirst($m['nombre']) }}</option>
            @endforeach
        </select>
        <select name="anio" style="border:1.5px solid #e0e0e0; border-radius:40px; padding:8px 16px; font-size:13px; outline:none; background:#FAFBF7;">
            @foreach(range(now()->year, now()->year - 2) as $a)
                <option value="{{ $a }}" {{ $anio == $a ? 'selected' : '' }}>{{ $a }}</option>
            @endforeach
        </select>
        <button type="submit" style="background:linear-gradient(135deg,#2E7D32,#1B5E20); color:#fff; font-weight:600; padding:8px 20px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
            <i class="ti ti-filter" style="font-size:13px;"></i> Filtrar
        </button>
    </form>
    {{-- Botones de Exportación --}}
    <div style="display:flex; gap:10px; align-items:center;">
        <a href="{{ route('admin.reportes.pdf', ['mes'=>$mes,'anio'=>$anio]) }}"
            style="display:inline-flex; align-items:center; gap:6px; background:#C62828; color:#fff; font-weight:600; padding:8px 20px; border-radius:40px; text-decoration:none; font-size:13px;">
            <i class="ti ti-file-type-pdf" style="font-size:15px;"></i> PDF
        </a>
        <a href="{{ route('admin.reportes.excel', ['mes'=>$mes,'anio'=>$anio]) }}"
            style="display:inline-flex; align-items:center; gap:6px; background:#1B5E20; color:#fff; font-weight:600; padding:8px 20px; border-radius:40px; text-decoration:none; font-size:13px;">
            <i class="ti ti-file-type-xls" style="font-size:15px;"></i> Excel
        </a>
    </div>
</div>

{{-- KPIs principales --}}
<div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(200px,1fr)); gap:16px; margin-bottom:24px;">
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-users" style="font-size:22px; color:#2E7D32;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#2E7D32;">{{ $totalClientes }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Clientes registrados</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E3F2FD; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-calendar-event" style="font-size:22px; color:#1565C0;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#1565C0;">{{ $citasHoy }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Citas hoy</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-calendar-month" style="font-size:22px; color:#2E7D32;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#2E7D32;">{{ $citasMes }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Citas este mes</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#F3E5F5; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-scissors" style="font-size:22px; color:#6A1B9A;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#6A1B9A;">{{ $totalGroomers }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Groomers activos</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#E8F5E9; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-circle-check" style="font-size:22px; color:#2E7D32;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#2E7D32;">{{ $citasCompletadas }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Citas completadas</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#FFEBEE; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-circle-x" style="font-size:22px; color:#C62828;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#C62828;">{{ $citasCanceladas }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Citas canceladas ({{ $tasaCancelacion }}%)</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="width:48px; height:48px; background:#FFF8E1; border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-package" style="font-size:22px; color:#F57F17;"></i></div>
        <p style="font-size:32px; font-weight:800; color:#F57F17;">{{ $productosBajoStock }}</p>
        <p style="font-size:13px; color:#8A9B8A;">Productos bajo stock</p>
    </div>
    <div class="stat-card" style="text-align:center; background:linear-gradient(135deg,#2E7D32,#1B5E20); color:white;">
        <div style="width:48px; height:48px; background:rgba(255,255,255,0.15); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;"><i class="ti ti-coin" style="font-size:22px; color:#fff;"></i></div>
        <p style="font-size:28px; font-weight:800;">Bs. {{ number_format($ingresosMes, 2) }}</p>
        <p style="font-size:13px; opacity:0.9;">Ingresos este mes</p>
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">

    {{-- Citas por estado --}}
    <div class="stat-card">
        <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-chart-pie" style="color:#2E7D32;"></i> Citas por estado
        </h3>
        @php
            $colores = ['agendada'=>'#F57F17','confirmada'=>'#2E7D32','en_progreso'=>'#1565C0','completada'=>'#6A1B9A','cancelada'=>'#C62828','no_asistio'=>'#757575'];
            $total = $citasPorEstado->sum();
        @endphp
        @foreach($citasPorEstado as $estado => $cantidad)
        <div style="margin-bottom:12px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                <span style="font-size:13px; color:#1A2E1A; font-weight:600;">{{ ucfirst(str_replace('_',' ',$estado)) }}</span>
                <span style="font-size:13px; color:#8A9B8A;">{{ $cantidad }}</span>
            </div>
            <div style="background:#F0F5F0; border-radius:10px; height:8px; overflow:hidden;">
                <div style="background:{{ $colores[$estado] ?? '#2E7D32' }}; height:100%; width:{{ $total > 0 ? ($cantidad/$total)*100 : 0 }}%; border-radius:10px;"></div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Ingresos últimos 6 meses --}}
    <div class="stat-card">
        <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-chart-bar" style="color:#2E7D32;"></i> Ingresos últimos 6 meses
        </h3>
        @php $maxIngreso = $ingresosPorMes->max('ingresos') ?: 1; @endphp
        @foreach($ingresosPorMes as $item)
        <div style="margin-bottom:10px;">
            <div style="display:flex; justify-content:space-between; margin-bottom:4px;">
                <span style="font-size:12px; color:#1A2E1A; font-weight:600; text-transform:capitalize;">{{ $item['mes'] }}</span>
                <span style="font-size:12px; color:#2E7D32; font-weight:700;">Bs. {{ number_format($item['ingresos'], 2) }}</span>
            </div>
            <div style="background:#F0F5F0; border-radius:10px; height:8px; overflow:hidden;">
                <div style="background:linear-gradient(135deg,#2E7D32,#1B5E20); height:100%; width:{{ ($item['ingresos']/$maxIngreso)*100 }}%; border-radius:10px;"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">

    {{-- Top servicios --}}
    <div class="stat-card">
        <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-trophy" style="color:#F57F17;"></i> Top servicios
        </h3>
        @forelse($topServicios as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #F0F5F0;">
            <span style="font-size:13px; color:#1A2E1A; font-weight:600;">{{ $item->servicio?->nombre ?? 'Sin servicio' }}</span>
            <span style="background:#E8F5E9; color:#2E7D32; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">{{ $item->total }} citas</span>
        </div>
        @empty
        <p style="color:#8A9B8A; font-size:13px;">No hay datos aún.</p>
        @endforelse
    </div>

    {{-- Citas por groomer --}}
    <div class="stat-card">
        <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-scissors" style="color:#6A1B9A;"></i> Citas por groomer
        </h3>
        @forelse($citasPorGroomer as $item)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #F0F5F0;">
            <span style="font-size:13px; color:#1A2E1A; font-weight:600;">{{ $item->groomer?->nombre ?? 'Sin groomer' }}</span>
            <span style="background:#F3E5F5; color:#6A1B9A; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">{{ $item->total }} citas</span>
        </div>
        @empty
        <p style="color:#8A9B8A; font-size:13px;">No hay datos aún.</p>
        @endforelse
    </div>
</div>

{{-- RANKING DE RENTABILIDAD --}}
<div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; overflow:hidden; margin-bottom:24px;">
    <div style="padding:20px 24px; border-bottom:1px solid #F0F0EA; background:linear-gradient(135deg,#2E7D32,#1B5E20);">
        <h3 style="font-size:16px; font-weight:700; color:#fff; margin:0; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-medal" style="font-size:18px;"></i> Ranking de rentabilidad — {{ ucfirst($meses->firstWhere('numero', $mes)['nombre'] ?? '') }} {{ $anio }}
        </h3>
        <p style="color:rgba(255,255,255,0.7); font-size:12px; margin:4px 0 0;">Servicios ordenados por ingresos generados en el período</p>
    </div>

    @if($rankingServicios->isEmpty())
        <div style="padding:48px; text-align:center; color:#8A9B8A; font-size:14px;">Sin datos para este período</div>
    @else
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#FAFBF7;">
                    <th style="padding:12px 20px; text-align:left; font-size:12px; color:#8A9B8A; font-weight:700; text-transform:uppercase;">#</th>
                    <th style="padding:12px 20px; text-align:left; font-size:12px; color:#8A9B8A; font-weight:700; text-transform:uppercase;">Servicio</th>
                    <th style="padding:12px 20px; text-align:center; font-size:12px; color:#8A9B8A; font-weight:700; text-transform:uppercase;">Citas</th>
                    <th style="padding:12px 20px; text-align:right; font-size:12px; color:#8A9B8A; font-weight:700; text-transform:uppercase;">Ingresos</th>
                    <th style="padding:12px 20px; text-align:right; font-size:12px; color:#8A9B8A; font-weight:700; text-transform:uppercase;">Promedio/cita</th>
                    <th style="padding:12px 20px; text-align:left; font-size:12px; color:#8A9B8A; font-weight:700; text-transform:uppercase;">Participación</th>
                </tr>
            </thead>
            <tbody>
                @php $totalIngresos = $rankingServicios->sum('ingresos'); @endphp
                @foreach($rankingServicios as $i => $item)
                <tr style="border-bottom:1px solid #F0F0EA; {{ $loop->even ? 'background:#FAFBF7;' : '' }}">
                    <td style="padding:14px 20px;">
                        @if($i === 0)
                            <span style="background:#FFF8E1; color:#F57F17; font-weight:800; font-size:14px; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">1</span>
                        @elseif($i === 1)
                            <span style="background:#F5F5F5; color:#757575; font-weight:800; font-size:14px; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">2</span>
                        @elseif($i === 2)
                            <span style="background:#FBE9E7; color:#BF360C; font-weight:800; font-size:14px; width:28px; height:28px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%;">3</span>
                        @else
                            <span style="color:#8A9B8A; font-weight:600; font-size:14px; padding-left:6px;">{{ $i + 1 }}</span>
                        @endif
                    </td>
                    <td style="padding:14px 20px; font-weight:700; color:#1A2E1A; font-size:14px;">{{ $item->servicio?->nombre ?? '—' }}</td>
                    <td style="padding:14px 20px; text-align:center;">
                        <span style="background:#E8F5E9; color:#2E7D32; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:700;">{{ $item->total_citas }}</span>
                    </td>
                    <td style="padding:14px 20px; text-align:right; font-weight:800; color:#2E7D32; font-size:15px;">Bs. {{ number_format($item->ingresos, 2) }}</td>
                    <td style="padding:14px 20px; text-align:right; color:#4F6B4F; font-size:13px; font-weight:600;">
                        Bs. {{ $item->total_citas > 0 ? number_format($item->ingresos / $item->total_citas, 2) : '0.00' }}
                    </td>
                    <td style="padding:14px 20px;">
                        @php $pct = $totalIngresos > 0 ? ($item->ingresos / $totalIngresos) * 100 : 0; @endphp
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="flex:1; background:#F0F5F0; border-radius:10px; height:8px; overflow:hidden;">
                                <div style="background:linear-gradient(135deg,#2E7D32,#1B5E20); height:100%; width:{{ $pct }}%; border-radius:10px;"></div>
                            </div>
                            <span style="font-size:12px; color:#8A9B8A; font-weight:600; min-width:35px;">{{ round($pct, 1) }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Últimas citas --}}
<div class="stat-card">
    <h3 style="font-size:15px; font-weight:700; color:#1A2E1A; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
        <i class="ti ti-clock" style="color:#2E7D32;"></i> Últimas citas
    </h3>
    @forelse($ultimasCitas as $cita)
    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #F0F5F0;">
        <div>
            <p style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $cita->mascota?->nombre ?? '—' }}</p>
            <p style="font-size:11px; color:#8A9B8A;">{{ $cita->servicio?->nombre ?? '—' }}</p>
        </div>
        <div style="text-align:right;">
            <p style="font-size:12px; color:#4F6B4F;">{{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
            @php
                $colores = ['agendada'=>['bg'=>'#FFF8E1','color'=>'#F57F17'],'confirmada'=>['bg'=>'#E8F5E9','color'=>'#2E7D32'],'completada'=>['bg'=>'#F3E5F5','color'=>'#6A1B9A'],'cancelada'=>['bg'=>'#FFEBEE','color'=>'#C62828'],'en_progreso'=>['bg'=>'#E3F2FD','color'=>'#1565C0']];
                $c = $colores[$cita->estado] ?? ['bg'=>'#F5F5F5','color'=>'#333'];
            @endphp
            <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">
                {{ ucfirst($cita->estado) }}
            </span>
        </div>
    </div>
    @empty
    <p style="color:#8A9B8A; font-size:13px;">No hay citas aún.</p>
    @endforelse
</div>

@endsection
