@extends('layouts.dashboard')

@section('page-title', '📅 Mis Citas')
@section('page-subtitle', 'Historial y estado de tus citas')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif
@if($errors->any())
<div class="alert alert-error">
    ⚠️ {{ $errors->first() }}
</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:20px; font-weight:700; color:#5d4037;">Mis Citas</h2>
    <a href="{{ route('cliente.citas.create') }}"
        style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:14px;">
        + Solicitar Cita
    </a>
</div>

@if($citas->isEmpty())
    <div class="stat-card" style="text-align:center; padding:48px;">
        <div style="font-size:64px; margin-bottom:16px;">📅</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037;">No tienes citas registradas</h3>
        <p style="color:#a1887f; margin-top:8px; font-size:14px;">Solicita una cita para tu mascota</p>
        <a href="{{ route('cliente.citas.create') }}"
            style="display:inline-block; margin-top:16px; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:12px 24px; border-radius:10px; text-decoration:none;">
            Solicitar primera cita
        </a>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:16px;">
        @foreach($citas as $cita)
        <div class="stat-card">
            <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:12px;">

                {{-- Info principal --}}
                <div style="display:flex; gap:16px; align-items:center;">
                    <div style="font-size:40px;">
                        @if($cita->mascota->especie === 'perro') 🐶
                        @elseif($cita->mascota->especie === 'gato') 🐱
                        @else 🐾
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size:16px; font-weight:700; color:#5d4037;">{{ $cita->mascota->nombre }}</h3>
                        <p style="font-size:13px; color:#a1887f;">{{ $cita->servicio->nombre }}</p>
                        <p style="font-size:13px; color:#8d6e63; margin-top:4px;">
                            📅 {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                            🕐 {{ $cita->fecha_hora_inicio->format('H:i') }}
                        </p>
                        @if($cita->groomer)
                        <p style="font-size:12px; color:#a1887f; margin-top:2px;">
                            ✂️ Groomer: {{ $cita->groomer->nombre }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Estado y precio --}}
                <div style="text-align:right;">
                    @php
                        $colores = [
                            'agendada'   => ['bg'=>'#fff3e0', 'color'=>'#e65100', 'label'=>'⏳ Agendada'],
                            'confirmada' => ['bg'=>'#e8f5e9', 'color'=>'#2e7d32', 'label'=>'✅ Confirmada'],
                            'en_progreso'=> ['bg'=>'#e3f2fd', 'color'=>'#1565c0', 'label'=>'🔄 En progreso'],
                            'completada' => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🎉 Completada'],
                            'cancelada'  => ['bg'=>'#ffebee', 'color'=>'#c62828', 'label'=>'❌ Cancelada'],
                            'no_asistio' => ['bg'=>'#fafafa', 'color'=>'#757575', 'label'=>'😔 No asistió'],
                            'en_revision' => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🔍 En revisión'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5', 'color'=>'#333', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">
                        {{ $c['label'] }}
                    </span>
                    <p style="font-size:16px; font-weight:700; color:#5d4037; margin-top:8px;">
                        Bs. {{ number_format($cita->precio_acordado, 2) }}
                    </p>

                    @if(in_array($cita->estado, ['agendada', 'confirmada']))
                    <form method="POST" action="{{ route('cliente.citas.destroy', $cita->id) }}" style="margin-top:8px;" class="form-cancelar">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="abrirModalCancelar(this.closest('form'))"
                            style="background:#ffebee; color:#c62828; font-weight:600; padding:6px 14px; border-radius:8px; border:none; cursor:pointer; font-size:12px; font-family:Poppins,sans-serif;">
                            Cancelar cita
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($cita->notas_cliente)
            <div style="background:#f5f0eb; border-radius:8px; padding:8px 12px; margin-top:12px;">
                <p style="font-size:12px; color:#8d6e63;">📝 {{ $cita->notas_cliente }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
@endif

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:420px; width:90%; text-align:center;">
        <div style="font-size:48px; margin-bottom:16px;">⚠️</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:8px;">Cancelar cita</h3>
        <p style="font-size:13px; color:#a1887f; margin-bottom:16px;">Por favor indica el motivo de cancelación.</p>

        <form id="form-cancelar" method="POST">
            @csrf
            @method('DELETE')

            {{-- Motivo --}}
            <div style="text-align:left; margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">
                    Motivo de cancelación *
                </label>
                <select name="motivo" id="select-motivo"
                    onchange="mostrarOtroMotivo(this)"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; margin-bottom:8px;"
                    required>
                    <option value="">Selecciona un motivo...</option>
                    <option value="Problemas de salud de la mascota">🐾 Salud de la mascota</option>
                    <option value="Problemas de salud del dueño">🏥 Salud del dueño</option>
                    <option value="Emergencia familiar">🚨 Emergencia familiar</option>
                    <option value="Falta de tiempo">⏰ Falta de tiempo</option>
                    <option value="Cambio de planes">📅 Cambio de planes</option>
                    <option value="otro">✏️ Otro motivo</option>
                </select>
                <div id="div-otro-motivo" style="display:none;">
                    <input type="text" name="motivo_otro" placeholder="Especifica el motivo..."
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                </div>
            </div>

            {{-- Política de cancelación --}}
            <div style="background:#fff3e0; border-radius:10px; padding:12px 16px; margin-bottom:16px; text-align:left;">
                <p style="font-size:13px; font-weight:600; color:#e65100; margin-bottom:8px;">📋 Política de cancelación:</p>
                <ul style="font-size:12px; color:#bf360c; margin:0; padding-left:16px;">
                    <li>Las cancelaciones deben realizarse con <strong>al menos 24 horas de anticipación</strong>.</li>
                    <li>Cancelaciones tardías pueden afectar futuras reservas.</li>
                    <li>El slot quedará disponible para otros clientes.</li>
                </ul>
            </div>

            {{-- Aceptar términos --}}
            <div style="display:flex; align-items:start; gap:10px; margin-bottom:20px; text-align:left;">
                <input type="checkbox" id="acepta-terminos" required
                    style="margin-top:3px; width:18px; height:18px; accent-color:#ff7043; flex-shrink:0;">
                <label for="acepta-terminos" style="font-size:13px; color:#5d4037; cursor:pointer;">
                    Entiendo y acepto la política de cancelación del Pet Spa.
                </label>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()"
                    style="flex:1; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Volver
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg,#ef5350,#e53935); color:white; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Confirmar cancelación
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let formCancelar = null;

function abrirModalCancelar(form) {
    formCancelar = form;
    document.getElementById('modal-cancelar').style.display = 'flex';
}

function cerrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}

function mostrarOtroMotivo(select) {
    const div = document.getElementById('div-otro-motivo');
    div.style.display = select.value === 'otro' ? 'block' : 'none';
}

document.getElementById('form-cancelar').addEventListener('submit', function(e) {
    const select  = document.getElementById('select-motivo');
    const terminos = document.getElementById('acepta-terminos');

    if (!select.value) {
        e.preventDefault();
        alert('Por favor selecciona un motivo de cancelación.');
        return;
    }

    if (!terminos.checked) {
        e.preventDefault();
        alert('Debes aceptar la política de cancelación.');
        return;
    }

    // Si eligió "otro" usar el campo de texto
    if (select.value === 'otro') {
        const otro = document.querySelector('input[name="motivo_otro"]').value;
        if (!otro) {
            e.preventDefault();
            alert('Por favor especifica el motivo.');
            return;
        }
        select.value = otro;
    }

    if (formCancelar) {
        this.action = formCancelar.action;
        formCancelar = null;
    }
});
</script>

@endsection