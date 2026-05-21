@extends('layouts.dashboard')

@section('page-title', '➕ Solicitar Cita')
@section('page-subtitle', 'Elige tu mascota, servicio y horario')

@section('content')
<div style="max-width:650px; margin:0 auto;">
    <div class="stat-card">

        @if($errors->any())
            <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($mascotas->isEmpty())
            <div style="text-align:center; padding:32px;">
                <div style="font-size:48px;">🐾</div>
                <p style="color:#a1887f; margin-top:12px;">Primero debes registrar una mascota.</p>
                <a href="{{ route('cliente.mascotas.create') }}"
                    style="display:inline-block; margin-top:12px; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:10px 20px; border-radius:10px; text-decoration:none;">
                    Registrar mascota
                </a>
            </div>
        @else

        <form method="POST" action="{{ route('cliente.citas.store') }}">
            @csrf

            {{-- Mascota --}}
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Mascota *</label>
                <select name="mascota_id" id="select-mascota"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                    onchange="actualizarDuracion()" required>
                    <option value="">Selecciona tu mascota...</option>
                    @foreach($mascotas as $mascota)
                        <option value="{{ $mascota->id }}"
                            data-tamano="{{ $mascota->tamano }}"
                            data-temperamento="{{ $mascota->temperamento }}"
                            {{ old('mascota_id') == $mascota->id ? 'selected' : '' }}>
                            {{ $mascota->nombre }} ({{ strtoupper($mascota->tamano) }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Servicio --}}
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Servicio *</label>
                <select name="servicio_id" id="select-servicio"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                    onchange="actualizarDuracion()" required>
                    <option value="">Selecciona un servicio...</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}"
                            data-duracion="{{ $servicio->duracion_base_minutos }}"
                            data-precio="{{ $servicio->precio_base }}"
                            data-factores="{{ json_encode($servicio->factor_tamano_raza) }}"
                            {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->nombre }} — Bs. {{ number_format($servicio->precio_base, 2) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Duración estimada --}}
            <div id="div-duracion" style="display:none; background:#fff3e0; border-radius:10px; padding:12px 16px; margin-bottom:16px;">
                <p style="font-size:13px; color:#e65100; font-weight:600;">
                    ⏱️ Duración estimada: <span id="texto-duracion"></span>
                </p>
                <p style="font-size:13px; color:#e65100; font-weight:600;">
                    💰 Precio: Bs. <span id="texto-precio"></span>
                </p>
            </div>

            {{-- Groomer --}}
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">
                    Groomer preferido <span style="color:#a1887f; font-weight:400;">(opcional)</span>
                </label>
                <select name="groomer_id"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                    <option value="">Sin preferencia (asignación automática)</option>
                    @foreach($groomers as $groomer)
                        <option value="{{ $groomer->id }}" {{ old('groomer_id') == $groomer->id ? 'selected' : '' }}>
                            {{ $groomer->nombre }} {{ $groomer->especialidad ? '— '.$groomer->especialidad : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha y hora --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Fecha *</label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Hora *</label>
                    <select name="hora"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                        <option value="">Selecciona...</option>
                        @for($h = 9; $h <= 17; $h++)
                            @foreach(['00', '30'] as $m)
                                @php $hora = sprintf('%02d:%s', $h, $m); @endphp
                                <option value="{{ $hora }}" {{ old('hora') === $hora ? 'selected' : '' }}>
                                    {{ $hora }}
                                </option>
                            @endforeach
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Notas --}}
            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">
                    Notas adicionales <span style="color:#a1887f; font-weight:400;">(opcional)</span>
                </label>
                <textarea name="notas_cliente" rows="3"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                    placeholder="Ej: Mi mascota es nerviosa, por favor tener cuidado...">{{ old('notas_cliente') }}</textarea>
            </div>

            <div style="display:flex; gap:12px;">
                <a href="{{ route('cliente.citas.index') }}"
                    style="flex:1; text-align:center; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
                    ← Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Solicitar Cita 📅
                </button>
            </div>
        </form>
        @endif
    </div>
</div>

<script>
function actualizarDuracion() {
    const mascotaSelect  = document.getElementById('select-mascota');
    const servicioSelect = document.getElementById('select-servicio');
    const divDuracion    = document.getElementById('div-duracion');

    const mascotaOption  = mascotaSelect.options[mascotaSelect.selectedIndex];
    const servicioOption = servicioSelect.options[servicioSelect.selectedIndex];

    if (!mascotaOption.value || !servicioOption.value) {
        divDuracion.style.display = 'none';
        return;
    }

    const tamano       = mascotaOption.dataset.tamano;
    const temperamento = mascotaOption.dataset.temperamento;
    const duracion     = parseInt(servicioOption.dataset.duracion);
    const precio       = parseFloat(servicioOption.dataset.precio);
    const factores     = JSON.parse(servicioOption.dataset.factores || '{}');
    const factor       = factores[tamano] || 1.0;
    let durFinal       = Math.ceil(duracion * factor);

    // Ajuste por temperamento
    let avisoTemperamento = '';
    if (temperamento === 'agresivo' || temperamento === 'nervioso') {
        durFinal = Math.ceil(durFinal * 1.20);
        avisoTemperamento = `<p style="font-size:12px; color:#c62828; margin-top:4px;">⚠️ Se agregó 20% de tiempo extra por temperamento ${temperamento}.</p>`;
    }

    document.getElementById('texto-duracion').textContent = durFinal + ' minutos';
    document.getElementById('texto-precio').textContent   = precio.toFixed(2);
    document.getElementById('div-duracion').innerHTML     = `
        <p style="font-size:13px; color:#e65100; font-weight:600;">⏱️ Duración estimada: <span>${durFinal} minutos</span></p>
        <p style="font-size:13px; color:#e65100; font-weight:600;">💰 Precio: Bs. <span>${precio.toFixed(2)}</span></p>
        ${avisoTemperamento}
    `;
    divDuracion.style.display = 'block';
}
</script>

@endsection