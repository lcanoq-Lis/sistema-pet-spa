@extends('layouts.dashboard')

@section('page-title', 'Mis Citas')
@section('page-subtitle', 'Historial y estado de tus citas')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

@if($errors->any())
    <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
        <p style="color:#C62828; font-size:13px; font-weight:500; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:36px; height:36px; background:linear-gradient(135deg, #FF7043, #F57F17); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-calendar" style="font-size:18px; color:#fff;"></i>
        </div>
        <h2 style="font-size:18px; font-weight:700; color:#1A2E1A; margin:0;">Mis Citas</h2>
    </div>
    <a href="{{ route('cliente.citas.create') }}"
        style="background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:10px 24px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:8px;">
        <i class="ti ti-plus" style="font-size:14px;"></i> Solicitar Cita
    </a>
</div>

@if($citas->isEmpty())
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:56px 24px;">
        <div style="width:72px; height:72px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-calendar-off" style="font-size:32px; color:#8A9B8A;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A2E1A;">No tienes citas registradas</h3>
        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Solicita una cita para tu mascota</p>
        <a href="{{ route('cliente.citas.create') }}"
            style="display:inline-flex; align-items:center; gap:8px; margin-top:16px; background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:12px 28px; border-radius:40px; text-decoration:none;">
            <i class="ti ti-calendar-plus" style="font-size:14px;"></i> Solicitar primera cita
        </a>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:18px;">
        @foreach($citas as $cita)
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:24px; transition:box-shadow 0.2s;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">

                {{-- Info principal --}}
                <div style="display:flex; gap:18px; align-items:center;">
                    <div style="width:56px; height:56px; background:#F5F5F0; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-dog" style="font-size:28px; color:#4A7A4A;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:16px; font-weight:800; color:#1A2E1A; margin:0;">{{ $cita->mascota->nombre }}</h3>
                        <p style="font-size:12px; color:#6B8F6B; margin:2px 0 0;">{{ $cita->servicio->nombre }}</p>
                        <div style="display:flex; align-items:center; gap:12px; margin-top:6px; flex-wrap:wrap;">
                            <span style="display:inline-flex; align-items:center; gap:4px; background:#F5F5F0; padding:3px 10px; border-radius:16px; font-size:11px; color:#5D6E5D;">
                                <i class="ti ti-calendar" style="font-size:11px;"></i> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                            </span>
                            <span style="display:inline-flex; align-items:center; gap:4px; background:#F5F5F0; padding:3px 10px; border-radius:16px; font-size:11px; color:#5D6E5D;">
                                <i class="ti ti-clock" style="font-size:11px;"></i> {{ $cita->fecha_hora_inicio->format('H:i') }}
                            </span>
                        </div>
                        @if($cita->groomer)
                        <p style="font-size:11px; color:#8A9B8A; margin-top:6px; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-scissors" style="font-size:11px;"></i> Groomer: {{ $cita->groomer->nombre }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Estado y precio --}}
                <div style="text-align:right;">
                    @php
                        $colores = [
                            'agendada'   => ['bg'=>'#FFF8E1', 'color'=>'#F57F17', 'icon'=>'ti-calendar', 'label'=>'Agendada'],
                            'confirmada' => ['bg'=>'#E8F5E9', 'color'=>'#2E7D32', 'icon'=>'ti-check', 'label'=>'Confirmada'],
                            'en_progreso'=> ['bg'=>'#E3F2FD', 'color'=>'#1565C0', 'icon'=>'ti-progress', 'label'=>'En progreso'],
                            'completada' => ['bg'=>'#F3E5F5', 'color'=>'#6A1B9A', 'icon'=>'ti-circle-check', 'label'=>'Completada'],
                            'cancelada'  => ['bg'=>'#FFEBEE', 'color'=>'#C62828', 'icon'=>'ti-x', 'label'=>'Cancelada'],
                            'no_asistio' => ['bg'=>'#FAFAFA', 'color'=>'#757575', 'icon'=>'ti-user-off', 'label'=>'No asistió'],
                            'en_revision'=> ['bg'=>'#F3E5F5', 'color'=>'#6A1B9A', 'icon'=>'ti-search', 'label'=>'En revisión'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'#F5F5F0', 'color'=>'#8A9B8A', 'icon'=>'ti-help', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="ti {{ $c['icon'] }}" style="font-size:11px;"></i> {{ $c['label'] }}
                    </span>
                    <p style="font-size:18px; font-weight:800; color:#FF7043; margin:8px 0 0;">
                        Bs. {{ number_format($cita->precio_acordado, 2) }}
                    </p>

                    @if(in_array($cita->estado, ['agendada', 'confirmada']))
                    <form method="POST" action="{{ route('cliente.citas.destroy', $cita->id) }}" style="margin-top:8px;" class="form-cancelar">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="abrirModalCancelar(this.closest('form'))"
                            style="background:#FFEBEE; color:#C62828; font-weight:600; padding:6px 16px; border-radius:40px; border:none; cursor:pointer; font-size:11px; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-x" style="font-size:12px;"></i> Cancelar cita
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            @if($cita->notas_cliente)
            <div style="background:#F9FBF6; border-radius:12px; padding:10px 14px; margin-top:14px; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-notes" style="font-size:14px; color:#8A9B8A;"></i>
                <p style="font-size:12px; color:#5D6E5D; margin:0;">{{ $cita->notas_cliente }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
@endif

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:32px; max-width:450px; width:90%; box-shadow:0 20px 35px -10px rgba(0,0,0,0.15); border:0.5px solid #e0e0e0;">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:64px; height:64px; background:#FFEBEE; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                <i class="ti ti-alert-triangle" style="font-size:32px; color:#C62828;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:800; color:#1A2E1A; margin:0;">Cancelar cita</h3>
            <p style="font-size:12px; color:#8A9B8A; margin-top:6px;">Por favor indica el motivo de cancelación.</p>
        </div>

        <form id="form-cancelar" method="POST">
            @csrf
            @method('DELETE')

            {{-- Motivo --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-list" style="font-size:12px;"></i> Motivo de cancelación *
                </label>
                <select name="motivo" id="select-motivo" onchange="mostrarOtroMotivo(this)"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                    required>
                    <option value="">Selecciona un motivo...</option>
                    <option value="Problemas de salud de la mascota">🐾 Salud de la mascota</option>
                    <option value="Problemas de salud del dueño">🏥 Salud del dueño</option>
                    <option value="Emergencia familiar">🚨 Emergencia familiar</option>
                    <option value="Falta de tiempo">⏰ Falta de tiempo</option>
                    <option value="Cambio de planes">📅 Cambio de planes</option>
                    <option value="otro">✏️ Otro motivo</option>
                </select>
                <div id="div-otro-motivo" style="display:none; margin-top:8px;">
                    <input type="text" name="motivo_otro" placeholder="Especifica el motivo..."
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                </div>
            </div>

            {{-- Política de cancelación --}}
            <div style="background:#FFF8E1; border-radius:14px; padding:14px 18px; margin-bottom:20px;">
                <p style="font-size:12px; font-weight:700; color:#E65100; margin-bottom:8px; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-file-text" style="font-size:13px;"></i> Política de cancelación:
                </p>
                <ul style="font-size:11px; color:#BF360C; margin:0; padding-left:18px;">
                    <li>Las cancelaciones deben realizarse con <strong>al menos 24 horas de anticipación</strong>.</li>
                    <li>Cancelaciones tardías pueden afectar futuras reservas.</li>
                    <li>El slot quedará disponible para otros clientes.</li>
                </ul>
            </div>

            {{-- Aceptar términos --}}
            <div style="display:flex; align-items:flex-start; gap:12px; margin-bottom:24px;">
                <input type="checkbox" id="acepta-terminos" required
                    style="margin-top:2px; width:18px; height:18px; accent-color:#C62828; flex-shrink:0;">
                <label for="acepta-terminos" style="font-size:12px; color:#5D6E5D; cursor:pointer;">
                    Entiendo y acepto la política de cancelación del Pet Spa.
                </label>
            </div>

            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()"
                    style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-arrow-left" style="font-size:13px;"></i> Volver
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg, #EF5350, #C62828); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:13px;"></i> Confirmar cancelación
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