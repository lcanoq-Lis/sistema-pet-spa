@extends('layouts.dashboard')

@section('page-title', 'Gestión de Citas')
@section('page-subtitle', 'Administra todas las citas del spa')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

{{-- Filtros de estado --}}
<div style="display:flex; gap:8px; margin-bottom:24px; flex-wrap:wrap;">
    @php
        $estados = [
            'todas'       => ['label'=>'Todas',        'color'=>'#5D6E5D', 'icon'=>'ti-calendar'],
            'agendada'    => ['label'=>'Agendadas',    'color'=>'#F57F17', 'icon'=>'ti-calendar'],
            'confirmada'  => ['label'=>'Confirmadas',  'color'=>'#2E7D32', 'icon'=>'ti-check'],
            'en_progreso' => ['label'=>'En progreso',  'color'=>'#1565C0', 'icon'=>'ti-progress'],
            'completada'  => ['label'=>'Completadas',  'color'=>'#6A1B9A', 'icon'=>'ti-circle-check'],
            'cancelada'   => ['label'=>'Canceladas',   'color'=>'#C62828', 'icon'=>'ti-x'],
            'en_revision' => ['label'=>'En revisión',  'color'=>'#6A1B9A', 'icon'=>'ti-search'],
        ];
        $filtro = request('estado', 'todas');
    @endphp

    @foreach($estados as $key => $est)
    <a href="{{ route('recepcion.citas.index', ['estado' => $key]) }}"
        style="padding:8px 20px; border-radius:30px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px;
               background:{{ $filtro === $key ? $est['color'] : '#fff' }};
               color:{{ $filtro === $key ? '#fff' : $est['color'] }};
               border:1px solid {{ $filtro === $key ? $est['color'] : '#e0e0e0' }};">
        <i class="ti {{ $est['icon'] }}" style="font-size:12px;"></i> {{ $est['label'] }}
    </a>
    @endforeach
</div>

{{-- Tabla de citas - VERSION RESPONSIVA --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow-x:auto; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="min-width:900px; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:linear-gradient(135deg, #1B5E20, #0D3B0D);">
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Mascota / Cliente</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Servicio</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Fecha y Hora</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Groomer</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Estado</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $citasFiltradas = $filtro === 'todas' ? $citas : $citas->where('estado', $filtro);
                @endphp

                @forelse($citasFiltradas as $cita)
                <tr style="border-bottom:1px solid #f0f0ea; {{ $loop->even ? 'background:#FAFBF8;' : '' }}">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; background:#F5F5F0; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="ti ti-dog" style="font-size:20px; color:#6B8F6B;"></i>
                            </div>
                            <div style="min-width:0;">
                                <p style="font-weight:700; color:#1A2E1A; font-size:14px; margin:0; word-break:break-word;">{{ $cita->mascota->nombre }}</p>
                                <p style="font-size:11px; color:#8A9B8A; margin:2px 0 0; display:flex; align-items:center; gap:4px;">
                                    <i class="ti ti-user" style="font-size:10px; flex-shrink:0;"></i> 
                                    <span style="word-break:break-word;">{{ $cita->creadoPor?->name ?? 'Sin cliente' }}</span>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:13px; color:#1A2E1A; font-weight:600; margin:0; word-break:break-word;">{{ $cita->servicio->nombre }}</p>
                        <p style="font-size:11px; color:#8A9B8A; margin:4px 0 0; display:flex; align-items:center; gap:3px;">
                            <i class="ti ti-coin" style="font-size:10px;"></i> Bs. {{ number_format($cita->precio_acordado, 2) }}
                        </p>
                    </td>
                    <td style="padding:16px 20px; white-space:nowrap;">
                        <p style="font-size:13px; color:#1A2E1A; font-weight:600; margin:0; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-calendar" style="font-size:12px; color:#6B8F6B;"></i> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                        </p>
                        <p style="font-size:11px; color:#8A9B8A; margin:4px 0 0; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-clock" style="font-size:10px;"></i> {{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}
                        </p>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:13px; color:#1A2E1A; margin:0; display:flex; align-items:center; gap:4px; white-space:nowrap;">
                            <i class="ti ti-scissors" style="font-size:12px; color:#6B8F6B; flex-shrink:0;"></i> 
                            <span>{{ $cita->groomer?->nombre ?? 'Sin asignar' }}</span>
                        </p>
                    </td>
                    <td style="padding:16px 20px;">
                        @php
                            $colores = [
                                'agendada'    => ['bg'=>'#FFF8E1', 'color'=>'#F57F17', 'icon'=>'ti-calendar', 'label'=>'Agendada'],
                                'confirmada'  => ['bg'=>'#E8F5E9', 'color'=>'#2E7D32', 'icon'=>'ti-check', 'label'=>'Confirmada'],
                                'en_progreso' => ['bg'=>'#E3F2FD', 'color'=>'#1565C0', 'icon'=>'ti-progress', 'label'=>'En progreso'],
                                'completada'  => ['bg'=>'#F3E5F5', 'color'=>'#6A1B9A', 'icon'=>'ti-circle-check', 'label'=>'Completada'],
                                'cancelada'   => ['bg'=>'#FFEBEE', 'color'=>'#C62828', 'icon'=>'ti-x', 'label'=>'Cancelada'],
                                'no_asistio'  => ['bg'=>'#FAFAFA', 'color'=>'#757575', 'icon'=>'ti-user-off', 'label'=>'No asistió'],
                                'en_revision' => ['bg'=>'#F3E5F5', 'color'=>'#6A1B9A', 'icon'=>'ti-search', 'label'=>'En revisión'],
                            ];
                            $c = $colores[$cita->estado] ?? ['bg'=>'#F5F5F0', 'color'=>'#8A9B8A', 'icon'=>'ti-help', 'label'=>$cita->estado];
                        @endphp
                        <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:5px 12px; border-radius:20px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:4px; white-space:nowrap;">
                            <i class="ti {{ $c['icon'] }}" style="font-size:10px;"></i> {{ $c['label'] }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;">
                        <div style="display:flex; gap:8px; flex-wrap:wrap;">
                            @if($cita->estado === 'agendada' || $cita->estado === 'en_revision')
                            <form method="POST" action="{{ route('recepcion.citas.confirmar', $cita->id) }}">
                                @csrf
                                <button type="submit" style="background:#E8F5E9; border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#2E7D32; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.2s;">
                                    <i class="ti ti-check" style="font-size:11px;"></i> Confirmar
                                </button>
                            </form>
                            @endif

                            @if($cita->estado === 'confirmada')
                            <form method="POST" action="{{ route('recepcion.citas.iniciar', $cita->id) }}">
                                @csrf
                                <button type="submit" style="background:#E3F2FD; border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#1565C0; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.2s;">
                                    <i class="ti ti-player-play" style="font-size:11px;"></i> Iniciar
                                </button>
                            </form>
                            @endif

                            @if($cita->estado === 'en_progreso')
                            <form method="POST" action="{{ route('recepcion.citas.completar', $cita->id) }}">
                                @csrf
                                <button type="submit" style="background:#F3E5F5; border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#6A1B9A; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.2s;">
                                    <i class="ti ti-circle-check" style="font-size:11px;"></i> Completar
                                </button>
                            </form>
                            @endif

                            @if(!in_array($cita->estado, ['cancelada', 'completada']))
                            <button type="button" onclick="abrirModalReprogramar({{ $cita->id }}, '{{ $cita->fecha_hora_inicio->format('Y-m-d') }}', '{{ $cita->fecha_hora_inicio->format('H:i') }}')"
                                style="background:#E8F5E9; border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#2E7D32; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.2s;">
                                <i class="ti ti-calendar-repeat" style="font-size:11px;"></i> Reprogramar
                            </button>
                            @endif

                            @if(!in_array($cita->estado, ['cancelada', 'completada']))
                            <button type="button" onclick="abrirModalCancelar({{ $cita->id }})"
                                style="background:#FFEBEE; border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#C62828; cursor:pointer; display:inline-flex; align-items:center; gap:4px; transition:all 0.2s;">
                                <i class="ti ti-x" style="font-size:11px;"></i> Cancelar
                            </button>
                            @endif

                            @if($cita->estado === 'completada' && !$cita->pago)
                            <a href="{{ route('recepcion.pagos.create', $cita->id) }}"
                                style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-cash" style="font-size:11px;"></i> Pago
                            </a>
                            @elseif($cita->pago)
                            <a href="{{ route('recepcion.pagos.factura', $cita->pago->id) }}"
                                style="background:#E8F5E9; border:none; border-radius:10px; padding:6px 12px; font-size:11px; font-weight:600; color:#2E7D32; text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-file-text" style="font-size:11px;"></i> Factura
                            </a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:56px 24px; text-align:center;">
                        <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="ti ti-calendar-off" style="font-size:28px; color:#8A9B8A;"></i>
                        </div>
                        <p style="color:#8A9B8A; font-size:14px; margin:0;">No hay citas para mostrar</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:28px; max-width:400px; width:90%; text-align:center; box-shadow:0 20px 35px -10px rgba(0,0,0,0.15); border:0.5px solid #e0e0e0;">
        <div style="width:56px; height:56px; background:#FFEBEE; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-alert-triangle" style="font-size:28px; color:#C62828;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:800; color:#1A2E1A; margin-bottom:8px;">Cancelar cita</h3>
        <p style="font-size:12px; color:#8A9B8A; margin-bottom:20px;">El cliente será notificado de la cancelación</p>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Motivo de cancelación (opcional)"
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px; font-size:13px; font-family:inherit; margin-bottom:20px; resize:none; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()"
                    style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-arrow-left" style="font-size:12px;"></i> Volver
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg, #EF5350, #C62828); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:12px;"></i> Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal reprogramar --}}
<div id="modal-reprogramar" style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:28px; max-width:400px; width:90%; box-shadow:0 20px 35px -10px rgba(0,0,0,0.15); border:0.5px solid #e0e0e0;">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:56px; height:56px; background:#E8F5E9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                <i class="ti ti-calendar-repeat" style="font-size:28px; color:#2E7D32;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:800; color:#1A2E1A; margin:0;">Reprogramar cita</h3>
            <p style="font-size:12px; color:#8A9B8A; margin-top:6px;">Selecciona nueva fecha y hora</p>
        </div>
        @if($errors->has('hora'))
        <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:10px; padding:10px 14px; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
            <i class="ti ti-alert-circle" style="color:#C62828; font-size:14px;"></i>
            <span style="color:#C62828; font-size:12px; font-weight:500;">{{ $errors->first('hora') }}</span>
        </div>
        @endif
        <form id="form-reprogramar" method="POST">
            @csrf
            <div style="margin-bottom:16px; text-align:left;">
                <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; margin-bottom:6px; text-transform:uppercase;">
                    <i class="ti ti-calendar" style="font-size:11px;"></i> Nueva fecha
                </label>
                <input type="date" name="fecha" id="reprogramar-fecha"
                    min="{{ now()->format('Y-m-d') }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#2E7D32'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div style="margin-bottom:24px; text-align:left;">
                <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; margin-bottom:6px; text-transform:uppercase;">
                    <i class="ti ti-clock" style="font-size:11px;"></i> Nueva hora
                </label>
                <select name="hora" id="reprogramar-hora"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; box-sizing:border-box;">
                    @for($h = 9; $h <= 17; $h++)
                        @foreach(['00', '30'] as $m)
                            @php $hora = sprintf('%02d:%s', $h, $m); @endphp
                            <option value="{{ $hora }}">{{ $hora }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalReprogramar()"
                    style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:12px;"></i> Cancelar
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg, #1B5E20, #0D3B0D); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-calendar-repeat" style="font-size:12px;"></i> Reprogramar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones para Cancelar
function abrirModalCancelar(id) {
    document.getElementById('form-cancelar').action = '/recepcion/citas/' + id + '/cancelar';
    document.getElementById('modal-cancelar').style.display = 'flex';
}
function cerrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}

// Funciones para Reprogramar
function abrirModalReprogramar(id, fecha, hora) {
    document.getElementById('form-reprogramar').action = '/recepcion/citas/' + id + '/reprogramar';
    document.getElementById('reprogramar-fecha').value = fecha;
    document.getElementById('reprogramar-hora').value  = hora;
    document.getElementById('modal-reprogramar').style.display = 'flex';
}
function cerrarModalReprogramar() {
    document.getElementById('modal-reprogramar').style.display = 'none';
}

// Reabrir modal si hay errores de validación
@if($errors->has('hora'))
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modal-reprogramar').style.display = 'flex';
    });
@endif
</script>
@endsection