@extends('layouts.dashboard')

@section('page-title', '⏰ Horarios y Bloqueos')
@section('page-subtitle', 'Configura el horario laboral del spa y registra bloqueos')

@section('content')
<div style="max-width:760px; margin:0 auto;">

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

{{-- ── HORARIO LABORAL ────────────────────────────────── --}}
<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:20px; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#1565c0,#1976d2); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:22px;">🕘</span>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Horario laboral del spa</h3>
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">Define los días y horas de atención</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.horarios.actualizar') }}" style="padding:20px;">
        @csrf

        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:14px;">
                <thead>
                    <tr style="border-bottom:2px solid #f5f0eb;">
                        <th style="text-align:left; padding:10px 12px; color:#5d4037; font-weight:700;">Día</th>
                        <th style="text-align:center; padding:10px 12px; color:#5d4037; font-weight:700;">Abierto</th>
                        <th style="text-align:center; padding:10px 12px; color:#5d4037; font-weight:700;">Apertura</th>
                        <th style="text-align:center; padding:10px 12px; color:#5d4037; font-weight:700;">Cierre</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horarios as $h)
                    <tr style="border-bottom:1px solid #f5f0eb;" id="fila-{{ $h->dia_semana }}">
                        <td style="padding:12px;">
                            <input type="hidden" name="horarios[{{ $loop->index }}][dia_semana]" value="{{ $h->dia_semana }}">
                            <span style="font-weight:600; color:#5d4037;">{{ $h->nombre_dia }}</span>
                        </td>
                        <td style="padding:12px; text-align:center;">
                            <label style="display:inline-flex; align-items:center; cursor:pointer; gap:6px;">
                                <input type="checkbox"
                                    name="horarios[{{ $loop->index }}][activo]"
                                    {{ $h->activo ? 'checked' : '' }}
                                    onchange="toggleFila({{ $h->dia_semana }}, this.checked)"
                                    style="width:18px; height:18px; cursor:pointer; accent-color:#ff7043;">
                            </label>
                        </td>
                        <td style="padding:12px; text-align:center;">
                            <input type="time"
                                name="horarios[{{ $loop->index }}][hora_apertura]"
                                value="{{ substr($h->hora_apertura, 0, 5) }}"
                                {{ !$h->activo ? 'disabled' : '' }}
                                style="border:2px solid #d7ccc8; border-radius:8px; padding:6px 10px; font-size:13px; font-family:Poppins,sans-serif; outline:none; width:110px;">
                        </td>
                        <td style="padding:12px; text-align:center;">
                            <input type="time"
                                name="horarios[{{ $loop->index }}][hora_cierre]"
                                value="{{ substr($h->hora_cierre, 0, 5) }}"
                                {{ !$h->activo ? 'disabled' : '' }}
                                style="border:2px solid #d7ccc8; border-radius:8px; padding:6px 10px; font-size:13px; font-family:Poppins,sans-serif; outline:none; width:110px;">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:16px; text-align:right;">
            <button type="submit"
                style="background:linear-gradient(135deg,#1565c0,#1976d2); color:white; font-weight:700; padding:10px 24px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                💾 Guardar horario
            </button>
        </div>
    </form>
</div>

{{-- ── REGISTRAR BLOQUEO ──────────────────────────────── --}}
<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); margin-bottom:20px; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#c62828,#e53935); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:22px;">🚫</span>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Registrar bloqueo</h3>
            <p style="font-size:11px; color:rgba(255,255,255,0.8); margin:0;">Feriados, ausencias o mantenimiento</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.horarios.bloqueo.store') }}" style="padding:20px;">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Fecha inicio</label>
                <input type="date" name="fecha_inicio" required min="{{ date('Y-m-d') }}"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Fecha fin</label>
                <input type="date" name="fecha_fin" required min="{{ date('Y-m-d') }}"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Tipo</label>
                <select name="tipo" required
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; background:white; box-sizing:border-box;">
                    <option value="feriado">🎉 Feriado</option>
                    <option value="mantenimiento">🔧 Mantenimiento</option>
                    <option value="ausencia">👤 Ausencia de groomer</option>
                    <option value="otro">📌 Otro</option>
                </select>
            </div>
            <div>
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Groomer afectado <span style="color:#a1887f; font-weight:400;">(opcional — vacío = todo el spa)</span></label>
                <select name="groomer_id"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; background:white; box-sizing:border-box;">
                    <option value="">🏠 Todo el spa</option>
                    @foreach($groomers as $g)
                        <option value="{{ $g->id }}">✂️ {{ $g->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Motivo</label>
            <input type="text" name="motivo" required maxlength="200"
                placeholder="Ej: Feriado nacional, limpieza general, vacaciones Eduardo..."
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; font-family:Poppins,sans-serif; outline:none; box-sizing:border-box;">
        </div>

        <div style="text-align:right;">
            <button type="submit"
                style="background:linear-gradient(135deg,#c62828,#e53935); color:white; font-weight:700; padding:10px 24px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                🚫 Registrar bloqueo
            </button>
        </div>
    </form>
</div>

{{-- ── LISTA DE BLOQUEOS ──────────────────────────────── --}}
<div style="background:white; border-radius:16px; box-shadow:0 2px 12px rgba(0,0,0,0.06); overflow:hidden;">
    <div style="padding:16px 20px; border-bottom:1px solid #f5f0eb; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">📋</span>
        <h3 style="font-size:15px; font-weight:700; color:#5d4037; margin:0;">Bloqueos registrados</h3>
        <span style="margin-left:auto; background:#f5f0eb; border-radius:20px; padding:3px 12px; font-size:12px; color:#5d4037; font-weight:600;">{{ $bloqueos->count() }}</span>
    </div>

    @if($bloqueos->isEmpty())
        <div style="padding:30px; text-align:center; color:#a1887f; font-size:13px;">
            📭 No hay bloqueos registrados.
        </div>
    @else
        <div style="padding:16px;">
            @foreach($bloqueos as $b)
            <div style="display:flex; align-items:center; gap:12px; padding:12px; border-radius:10px; background:#fafafa; margin-bottom:8px; border:1px solid #f0ebe5;">
                <div style="font-size:22px;">
                    @if($b->tipo === 'feriado') 🎉
                    @elseif($b->tipo === 'mantenimiento') 🔧
                    @elseif($b->tipo === 'ausencia') 👤
                    @else 📌
                    @endif
                </div>
                <div style="flex:1;">
                    <p style="font-size:14px; font-weight:600; color:#5d4037; margin:0;">{{ $b->motivo }}</p>
                    <p style="font-size:12px; color:#a1887f; margin:2px 0 0;">
                        📅 {{ $b->fecha_inicio->format('d/m/Y') }}
                        @if($b->fecha_inicio != $b->fecha_fin)
                            → {{ $b->fecha_fin->format('d/m/Y') }}
                        @endif
                        · {{ ucfirst($b->tipo) }}
                        @if($b->groomer)
                            · ✂️ Solo {{ $b->groomer->nombre }}
                        @else
                            · 🏠 Todo el spa
                        @endif
                    </p>
                </div>
                <form method="POST" action="{{ route('admin.horarios.bloqueo.destroy', $b->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('¿Eliminar este bloqueo?')"
                        style="background:#fff5f5; color:#c62828; border:1px solid #ffcdd2; border-radius:8px; padding:6px 12px; font-size:12px; cursor:pointer; font-family:Poppins,sans-serif;">
                        ✕ Eliminar
                    </button>
                </form>
            </div>
            @endforeach
        </div>
    @endif
</div>

</div>

<script>
function toggleFila(dia, activo) {
    const fila = document.getElementById('fila-' + dia);
    const inputs = fila.querySelectorAll('input[type="time"]');
    inputs.forEach(i => {
        i.disabled = !activo;
        i.style.opacity = activo ? '1' : '0.4';
    });
}
</script>
@endsection
