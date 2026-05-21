@extends('layouts.dashboard')
@section('page-title', '📆 Calendario Maestro')
@section('page-subtitle', 'Vista semanal de citas por groomer')

@section('content')

<div style="max-width:100%;">

{{-- Navegación de semana --}}
<div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; gap:10px;">
    <a href="{{ route('recepcion.calendario', ['semana' => $semanaAnterior]) }}"
        style="padding:8px 18px; border-radius:10px; background:white; border:2px solid #d7ccc8; color:#5d4037; font-weight:600; font-size:13px; text-decoration:none;">
        ← Semana anterior
    </a>

    <div style="text-align:center;">
        <p style="font-size:16px; font-weight:700; color:#5d4037; margin:0;">
            {{ $diasSemana[0]->format('d') }} — {{ $diasSemana[6]->format('d \d\e F, Y') }}
        </p>
        <p style="font-size:12px; color:#a1887f; margin:0;">Semana {{ $semanaActual }}</p>
    </div>

    <a href="{{ route('recepcion.calendario', ['semana' => $semanaProxima]) }}"
        style="padding:8px 18px; border-radius:10px; background:white; border:2px solid #d7ccc8; color:#5d4037; font-weight:600; font-size:13px; text-decoration:none;">
        Semana siguiente →
    </a>
</div>

{{-- Filtro por groomer --}}
<div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap;">
    <a href="{{ route('recepcion.calendario', ['semana' => $semanaActual, 'groomer' => 'todos']) }}"
        style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none;
               background:{{ $groomerFiltro === 'todos' ? '#ff7043' : '#f5f0eb' }};
               color:{{ $groomerFiltro === 'todos' ? 'white' : '#5d4037' }};">
        👥 Todos
    </a>
    @foreach($groomers as $g)
    <a href="{{ route('recepcion.calendario', ['semana' => $semanaActual, 'groomer' => $g->id]) }}"
        style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none;
               background:{{ $groomerFiltro == $g->id ? '#ff7043' : '#f5f0eb' }};
               color:{{ $groomerFiltro == $g->id ? 'white' : '#5d4037' }};">
        ✂️ {{ $g->nombre }}
    </a>
    @endforeach
</div>

{{-- Calendario semanal --}}
<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden;">

    {{-- Header días --}}
    <div style="display:grid; grid-template-columns: 80px repeat(7, 1fr); background:linear-gradient(135deg,#ff7043,#ff8f00);">
        <div style="padding:12px; border-right:1px solid rgba(255,255,255,0.2);"></div>
        @foreach($diasSemana as $dia)
        @php $esHoy = $dia->isToday(); @endphp
        <div style="padding:12px 8px; text-align:center; border-right:1px solid rgba(255,255,255,0.2); {{ $esHoy ? 'background:rgba(255,255,255,0.2);' : '' }}">
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0; text-transform:uppercase;">{{ $dia->locale('es')->isoFormat('ddd') }}</p>
            <p style="font-size:18px; font-weight:700; color:white; margin:0;">{{ $dia->format('d') }}</p>
            @if($esHoy)
                <span style="background:white; color:#ff7043; font-size:9px; font-weight:700; padding:1px 6px; border-radius:10px;">HOY</span>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Slots de horas --}}
    @foreach($horas as $hora)
    <div style="display:grid; grid-template-columns: 80px repeat(7, 1fr); border-bottom:1px solid #f5f0eb; min-height:60px;">

        {{-- Hora --}}
        <div style="padding:8px; text-align:center; border-right:1px solid #f5f0eb; background:#fafafa; display:flex; align-items:flex-start; justify-content:center;">
            <span style="font-size:11px; font-weight:600; color:#a1887f;">{{ $hora }}</span>
        </div>

        {{-- Celdas por día --}}
        @foreach($diasSemana as $dia)
        @php
            $fechaStr = $dia->format('Y-m-d');
            $citasSlot = $citasPorDia[$fechaStr] ?? collect();
            $citasHora = $citasSlot->filter(function($c) use ($hora) {
                return $c->fecha_hora_inicio->format('H:i') === $hora;
            });
            $esHoy = $dia->isToday();
            $esPasado = $dia->isPast() && !$esHoy;
        @endphp
        <div style="padding:4px; border-right:1px solid #f5f0eb; {{ $esHoy ? 'background:#fff8f5;' : '' }}{{ $esPasado ? 'background:#fafafa;' : '' }} vertical-align:top;">
            @foreach($citasHora as $cita)
            @php
                $colores = [
                    'agendada'    => ['bg'=>'#fff3e0', 'border'=>'#ff9800', 'text'=>'#e65100'],
                    'confirmada'  => ['bg'=>'#e8f5e9', 'border'=>'#4caf50', 'text'=>'#2e7d32'],
                    'en_progreso' => ['bg'=>'#e3f2fd', 'border'=>'#2196f3', 'text'=>'#1565c0'],
                    'completada'  => ['bg'=>'#f3e5f5', 'border'=>'#9c27b0', 'text'=>'#6a1b9a'],
                    'cancelada'   => ['bg'=>'#ffebee', 'border'=>'#f44336', 'text'=>'#c62828'],
                ];
                $cc = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5','border'=>'#ccc','text'=>'#333'];
            @endphp
            <div style="background:{{ $cc['bg'] }}; border-left:3px solid {{ $cc['border'] }}; border-radius:6px; padding:4px 6px; margin-bottom:3px; cursor:pointer;"
                onclick="abrirDetalle({{ $cita->id }}, '{{ addslashes($cita->mascota->nombre) }}', '{{ addslashes($cita->servicio->nombre) }}', '{{ $cita->fecha_hora_inicio->format('H:i') }}', '{{ $cita->fecha_hora_fin_estimada->format('H:i') }}', '{{ addslashes($cita->groomer?->nombre ?? 'Sin asignar') }}', '{{ $cita->estado }}', '{{ addslashes($cita->mascota->especie) }}')">
                <p style="font-size:11px; font-weight:700; color:{{ $cc['text'] }}; margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $cita->mascota->nombre }}
                </p>
                <p style="font-size:10px; color:{{ $cc['text'] }}; margin:0; opacity:0.8; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                    {{ $cita->groomer?->nombre ?? '—' }}
                </p>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
    @endforeach
</div>

{{-- Leyenda --}}
<div style="display:flex; gap:12px; margin-top:16px; flex-wrap:wrap;">
    @foreach(['agendada'=>['#fff3e0','#ff9800','⏳ Agendada'], 'confirmada'=>['#e8f5e9','#4caf50','✅ Confirmada'], 'en_progreso'=>['#e3f2fd','#2196f3','🔄 En progreso'], 'completada'=>['#f3e5f5','#9c27b0','🎉 Completada'], 'cancelada'=>['#ffebee','#f44336','❌ Cancelada']] as $est => $d)
    <div style="display:flex; align-items:center; gap:6px;">
        <div style="width:14px; height:14px; border-radius:3px; background:{{ $d[0] }}; border-left:3px solid {{ $d[1] }};"></div>
        <span style="font-size:12px; color:#5d4037;">{{ $d[2] }}</span>
    </div>
    @endforeach
</div>

</div>

{{-- Modal detalle cita --}}
<div id="modal-detalle" onclick="cerrarDetalle()"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
    <div onclick="event.stopPropagation()"
        style="background:white; border-radius:16px; padding:28px; max-width:380px; width:90%; box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:16px;">
            <div>
                <p id="modal-especie" style="font-size:28px; margin:0;"></p>
                <h3 id="modal-mascota" style="font-size:18px; font-weight:700; color:#5d4037; margin:4px 0 0;"></h3>
            </div>
            <button onclick="cerrarDetalle()" style="background:none; border:none; font-size:20px; cursor:pointer; color:#a1887f;">✕</button>
        </div>
        <div style="display:grid; gap:10px; margin-bottom:20px;">
            <div style="display:flex; gap:10px; align-items:center; background:#f5f0eb; border-radius:10px; padding:10px 14px;">
                <span style="font-size:18px;">✂️</span>
                <div>
                    <p style="font-size:11px; color:#a1887f; margin:0;">Servicio</p>
                    <p id="modal-servicio" style="font-size:14px; font-weight:600; color:#5d4037; margin:0;"></p>
                </div>
            </div>
            <div style="display:flex; gap:10px; align-items:center; background:#f5f0eb; border-radius:10px; padding:10px 14px;">
                <span style="font-size:18px;">🕐</span>
                <div>
                    <p style="font-size:11px; color:#a1887f; margin:0;">Horario</p>
                    <p id="modal-hora" style="font-size:14px; font-weight:600; color:#5d4037; margin:0;"></p>
                </div>
            </div>
            <div style="display:flex; gap:10px; align-items:center; background:#f5f0eb; border-radius:10px; padding:10px 14px;">
                <span style="font-size:18px;">👤</span>
                <div>
                    <p style="font-size:11px; color:#a1887f; margin:0;">Groomer</p>
                    <p id="modal-groomer" style="font-size:14px; font-weight:600; color:#5d4037; margin:0;"></p>
                </div>
            </div>
            <div style="display:flex; gap:10px; align-items:center; background:#f5f0eb; border-radius:10px; padding:10px 14px;">
                <span style="font-size:18px;">📌</span>
                <div>
                    <p style="font-size:11px; color:#a1887f; margin:0;">Estado</p>
                    <p id="modal-estado" style="font-size:14px; font-weight:600; color:#5d4037; margin:0;"></p>
                </div>
            </div>
        </div>
        <a id="modal-link" href="#"
            style="display:block; text-align:center; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
            Ver detalle completo →
        </a>
    </div>
</div>

<script>
function abrirDetalle(id, mascota, servicio, horaInicio, horaFin, groomer, estado, especie) {
    const iconos = { perro:'🐶', gato:'🐱', hamster:'🐹', conejo:'🐰' };
    const estadoLabels = {
        agendada:'⏳ Agendada', confirmada:'✅ Confirmada',
        en_progreso:'🔄 En progreso', completada:'🎉 Completada', cancelada:'❌ Cancelada'
    };
    document.getElementById('modal-especie').textContent  = iconos[especie] || '🐾';
    document.getElementById('modal-mascota').textContent  = mascota;
    document.getElementById('modal-servicio').textContent = servicio;
    document.getElementById('modal-hora').textContent     = horaInicio + ' — ' + horaFin;
    document.getElementById('modal-groomer').textContent  = groomer;
    document.getElementById('modal-estado').textContent   = estadoLabels[estado] || estado;
    document.getElementById('modal-link').href = '/recepcion/citas?estado=todas';
    document.getElementById('modal-detalle').style.display = 'flex';
}
function cerrarDetalle() {
    document.getElementById('modal-detalle').style.display = 'none';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarDetalle(); });
</script>
@endsection
