@extends('layouts.dashboard')

@section('page-title', 'Horarios y Bloqueos')
@section('page-subtitle', 'Configura el horario laboral del spa y registra bloqueos')

@section('content')
<div style="max-width:900px; margin:0 auto;">

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

{{-- ── HORARIO LABORAL ────────────────────────────────── --}}
<div style="background:#fff; border-radius:24px; border:0.5px solid #e0e0e0; margin-bottom:28px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.03);">
    <div style="background:linear-gradient(135deg, #1565C0, #0D3B5E); padding:20px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-clock" style="font-size:20px; color:#fff;"></i>
        </div>
        <div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0;">Horario laboral del spa</h3>
            <p style="font-size:12px; color:#BBDEFB; margin:4px 0 0;">Define los días y horas de atención</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.horarios.actualizar') }}" style="padding:24px;">
        @csrf

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:13px;">
                <thead>
                    <tr style="border-bottom:2px solid #F0F0EA;">
                        <th style="text-align:left; padding:12px 16px; color:#5D6E5D; font-weight:700;">Día</th>
                        <th style="text-align:center; padding:12px 16px; color:#5D6E5D; font-weight:700;">Abierto</th>
                        <th style="text-align:center; padding:12px 16px; color:#5D6E5D; font-weight:700;">Apertura</th>
                        <th style="text-align:center; padding:12px 16px; color:#5D6E5D; font-weight:700;">Cierre</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $diasSemana = [
                            1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves',
                            5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'
                        ];
                    @endphp
                    @foreach($horarios as $index => $h)
                    <tr style="border-bottom:1px solid #F0F0EA; {{ $loop->even ? 'background:#FAFBF8;' : '' }}" id="fila-{{ $h->dia_semana }}">
                        <td style="padding:14px 16px;">
                            <input type="hidden" name="horarios[{{ $index }}][dia_semana]" value="{{ $h->dia_semana }}">
                            <span style="font-weight:700; color:#1A2E1A; display:flex; align-items:center; gap:8px;">
                                <i class="ti ti-calendar" style="font-size:14px; color:#8A9B8A;"></i> {{ $diasSemana[$h->dia_semana] ?? 'Desconocido' }}
                            </span>
                        </td>
                        <td style="padding:14px 16px; text-align:center;">
                            <label style="display:inline-flex; align-items:center; cursor:pointer;">
                                <input type="checkbox"
                                    name="horarios[{{ $index }}][activo]"
                                    {{ $h->activo ? 'checked' : '' }}
                                    onchange="toggleFila({{ $h->dia_semana }}, this.checked)"
                                    style="width:20px; height:20px; cursor:pointer; accent-color:#1565C0;">
                            </label>
                        </td>
                        <td style="padding:14px 16px; text-align:center;">
                            <input type="time"
                                name="horarios[{{ $index }}][hora_apertura]"
                                value="{{ substr($h->hora_apertura, 0, 5) }}"
                                {{ !$h->activo ? 'disabled' : '' }}
                                style="border:1.5px solid #e0e0e0; border-radius:10px; padding:8px 12px; font-size:13px; font-family:inherit; outline:none; background:{{ $h->activo ? '#FAFBF7' : '#F5F5F0' }}; width:110px; transition:all 0.2s;"
                                onfocus="this.style.borderColor='#1565C0'; this.style.background='#fff'"
                                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                        </td>
                        <td style="padding:14px 16px; text-align:center;">
                            <input type="time"
                                name="horarios[{{ $index }}][hora_cierre]"
                                value="{{ substr($h->hora_cierre, 0, 5) }}"
                                {{ !$h->activo ? 'disabled' : '' }}
                                style="border:1.5px solid #e0e0e0; border-radius:10px; padding:8px 12px; font-size:13px; font-family:inherit; outline:none; background:{{ $h->activo ? '#FAFBF7' : '#F5F5F0' }}; width:110px; transition:all 0.2s;"
                                onfocus="this.style.borderColor='#1565C0'; this.style.background='#fff'"
                                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:24px; text-align:right;">
            <button type="submit"
                style="background:linear-gradient(135deg, #1565C0, #0D3B5E); color:#fff; font-weight:700; padding:12px 28px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
                <i class="ti ti-device-floppy" style="font-size:14px;"></i> Guardar horario
            </button>
        </div>
    </form>
</div>

{{-- ── REGISTRAR BLOQUEO ──────────────────────────────── --}}
<div style="background:#fff; border-radius:24px; border:0.5px solid #e0e0e0; margin-bottom:28px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.03);">
    <div style="background:linear-gradient(135deg, #C62828, #8B0000); padding:20px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-ban" style="font-size:20px; color:#fff;"></i>
        </div>
        <div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0;">Registrar bloqueo</h3>
            <p style="font-size:12px; color:#FFCDD2; margin:4px 0 0;">Feriados, ausencias o mantenimiento</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.horarios.bloqueo.store') }}" style="padding:24px;">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-calendar-start" style="font-size:12px;"></i> Fecha inicio *
                </label>
                <input type="date" name="fecha_inicio" required min="{{ date('Y-m-d') }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-calendar-end" style="font-size:12px;"></i> Fecha fin *
                </label>
                <input type="date" name="fecha_fin" required min="{{ date('Y-m-d') }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-tag" style="font-size:12px;"></i> Tipo
                </label>
                <select name="tipo" required
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                    <option value="feriado">🎉 Feriado</option>
                    <option value="mantenimiento">🔧 Mantenimiento</option>
                    <option value="ausencia">👤 Ausencia de groomer</option>
                    <option value="otro">📌 Otro</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-scissors" style="font-size:12px;"></i> Groomer afectado
                    <span style="color:#8A9B8A; font-weight:400;">(opcional)</span>
                </label>
                <select name="groomer_id"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                    <option value="">🏠 Todo el spa</option>
                    @foreach($groomers as $g)
                        <option value="{{ $g->id }}">✂️ {{ $g->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-message" style="font-size:12px;"></i> Motivo *
            </label>
            <input type="text" name="motivo" required maxlength="200"
                placeholder="Ej: Feriado nacional, limpieza general, vacaciones Eduardo..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <div style="text-align:right;">
            <button type="submit"
                style="background:linear-gradient(135deg, #C62828, #8B0000); color:#fff; font-weight:700; padding:12px 28px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
                <i class="ti ti-ban" style="font-size:14px;"></i> Registrar bloqueo
            </button>
        </div>
    </form>
</div>

{{-- ── LISTA DE BLOQUEOS ──────────────────────────────── --}}
<div style="background:#fff; border-radius:24px; border:0.5px solid #e0e0e0; margin-bottom:28px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.03);">
    <div style="padding:20px 24px; border-bottom:1px solid #F0F0EA; display:flex; align-items:center; gap:12px; background:#FAFBF8;">
        <div style="width:36px; height:36px; background:#FFEBEE; border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-list" style="font-size:18px; color:#C62828;"></i>
        </div>
        <h3 style="font-size:15px; font-weight:800; color:#1A2E1A; margin:0;">Bloqueos registrados</h3>
        <span style="margin-left:auto; background:#C62828; color:#fff; border-radius:30px; padding:4px 14px; font-size:12px; font-weight:700;">{{ $bloqueos->count() }}</span>
    </div>

    @if($bloqueos->isEmpty())
        <div style="padding:48px 24px; text-align:center;">
            <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                <i class="ti ti-calendar-off" style="font-size:28px; color:#8A9B8A;"></i>
            </div>
            <p style="color:#8A9B8A; font-size:13px; margin:0;">No hay bloqueos registrados.</p>
        </div>
    @else
        <div style="padding:20px;">
            @foreach($bloqueos as $b)
            <div style="display:flex; align-items:center; gap:14px; padding:14px 16px; border-radius:16px; background:#FAFBF8; margin-bottom:10px; border:1px solid #F0F0EA; transition:all 0.2s;">
                <div style="width:44px; height:44px; background:{{ $b->tipo === 'feriado' ? '#FFF8E1' : ($b->tipo === 'mantenimiento' ? '#E3F2FD' : ($b->tipo === 'ausencia' ? '#FFEBEE' : '#F5F5F0')) }}; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    @if($b->tipo === 'feriado')
                        <i class="ti ti-cake" style="font-size:22px; color:#F57F17;"></i>
                    @elseif($b->tipo === 'mantenimiento')
                        <i class="ti ti-tools" style="font-size:22px; color:#1565C0;"></i>
                    @elseif($b->tipo === 'ausencia')
                        <i class="ti ti-user-x" style="font-size:22px; color:#C62828;"></i>
                    @else
                        <i class="ti ti-alert-circle" style="font-size:22px; color:#8A9B8A;"></i>
                    @endif
                </div>
                <div style="flex:1;">
                    <p style="font-size:14px; font-weight:800; color:#1A2E1A; margin:0;">{{ $b->motivo }}</p>
                    <div style="display:flex; flex-wrap:wrap; gap:12px; margin-top:6px;">
                        <span style="font-size:11px; color:#8A9B8A; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-calendar" style="font-size:11px;"></i> {{ $b->fecha_inicio->format('d/m/Y') }}
                            @if($b->fecha_inicio != $b->fecha_fin)
                                → {{ $b->fecha_fin->format('d/m/Y') }}
                            @endif
                        </span>
                        <span style="font-size:11px; font-weight:600; padding:2px 10px; border-radius:20px; background:#F5F5F0; color:#5D6E5D; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-tag" style="font-size:10px;"></i> {{ ucfirst($b->tipo) }}
                        </span>
                        @if($b->groomer)
                        <span style="font-size:11px; font-weight:600; padding:2px 10px; border-radius:20px; background:#FFEBEE; color:#C62828; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-scissors" style="font-size:10px;"></i> Solo {{ $b->groomer->nombre }}
                        </span>
                        @else
                        <span style="font-size:11px; font-weight:600; padding:2px 10px; border-radius:20px; background:#E8F5E9; color:#2E7D32; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-building" style="font-size:10px;"></i> Todo el spa
                        </span>
                        @endif
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.horarios.bloqueo.destroy', $b->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar este bloqueo?')"
                        style="background:#FFEBEE; color:#C62828; border:1px solid #FFCDD2; border-radius:10px; padding:8px 14px; font-size:12px; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                        <i class="ti ti-trash" style="font-size:12px;"></i> Eliminar
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    @endif
</div>

{{-- ── CONFIGURACIÓN DEL SISTEMA ────────────────────────── --}}
<div style="background:#fff; border-radius:24px; border:0.5px solid #e0e0e0; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.03);">
    <div style="background:linear-gradient(135deg, #5D4037, #3E2723); padding:20px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:40px; height:40px; background:rgba(255,255,255,0.15); border-radius:12px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-settings" style="font-size:20px; color:#fff;"></i>
        </div>
        <div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0;">Configuración del sistema</h3>
            <p style="font-size:12px; color:#D7CCC8; margin:4px 0 0;">Parámetros generales del negocio</p>
        </div>
    </div>
    <form method="POST" action="{{ route('admin.configuracion.guardar') }}" style="padding:24px;">
        @csrf
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-package" style="font-size:12px;"></i> Límite de insumos por groomer/semana
                </label>
                <input type="number" name="limite_insumos_semana" min="1"
                    value="{{ \App\Models\Configuracion::obtener('limite_insumos_semana', 20) }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#5D4037'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                <p style="font-size:11px; color:#8A9B8A; margin-top:6px; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-info-circle" style="font-size:11px;"></i> Se enviará alerta si un groomer supera este límite
                </p>
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-clock" style="font-size:12px;"></i> Horas mínimas para cancelar cita
                </label>
                <input type="number" name="horas_cancelacion" min="1"
                    value="{{ \App\Models\Configuracion::obtener('horas_cancelacion', 24) }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#5D4037'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                <p style="font-size:11px; color:#8A9B8A; margin-top:6px; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-info-circle" style="font-size:11px;"></i> El cliente no podrá cancelar con menos de estas horas
                </p>
            </div>
        </div>
        <div style="margin-top:28px; text-align:right;">
            <button type="submit"
                style="background:linear-gradient(135deg, #5D4037, #3E2723); color:#fff; font-weight:700; padding:12px 28px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
                <i class="ti ti-device-floppy" style="font-size:14px;"></i> Guardar configuración
            </button>
        </div>
    </form>
</div>

</div>

<script>
function toggleFila(dia, activo) {
    const fila = document.getElementById('fila-' + dia);
    const inputs = fila.querySelectorAll('input[type="time"]');
    inputs.forEach(i => {
        i.disabled = !activo;
        i.style.opacity = activo ? '1' : '0.6';
        i.style.background = activo ? '#FAFBF7' : '#F5F5F0';
    });
}

// Asegurar que las fechas de fin no sean menores a las de inicio
document.addEventListener('DOMContentLoaded', function() {
    const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
    const fechaFin = document.querySelector('input[name="fecha_fin"]');
    
    if (fechaInicio && fechaFin) {
        fechaInicio.addEventListener('change', function() {
            if (fechaFin.value < this.value) {
                fechaFin.value = this.value;
            }
            fechaFin.min = this.value;
        });
    }
});
</script>
@endsection