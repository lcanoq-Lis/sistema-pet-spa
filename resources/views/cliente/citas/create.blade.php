@extends('layouts.dashboard')

@section('page-title', 'Solicitar Cita')
@section('page-subtitle', 'Elige tu mascota, servicio y horario')

@section('content')
<div style="max-width:650px; margin:0 auto;">
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:28px;">

        @if($errors->any())
            <div style="background:#FFF8E1; border-left:4px solid #FF7043; border-radius:12px; padding:14px 18px; margin-bottom:24px;">
                <ul style="margin:0; padding-left:20px; color:#E65100; font-size:13px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($mascotas->isEmpty())
            <div style="text-align:center; padding:40px 24px;">
                <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                    <i class="ti ti-paw" style="font-size:28px; color:#8A9B8A;"></i>
                </div>
                <p style="color:#8A9B8A; font-size:14px; margin:0 0 12px;">Primero debes registrar una mascota.</p>
                <a href="{{ route('cliente.mascotas.create') }}"
                    style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:12px 24px; border-radius:40px; text-decoration:none;">
                    <i class="ti ti-dog" style="font-size:16px;"></i> Registrar mascota
                </a>
            </div>
        @else

        <form method="POST" action="{{ route('cliente.citas.store') }}">
            @csrf

            {{-- Mascota --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-dog" style="font-size:12px;"></i> Mascota *
                </label>
                <select name="mascota_id" id="select-mascota"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
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
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-scissors" style="font-size:12px;"></i> Servicio *
                </label>
                <select name="servicio_id" id="select-servicio"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
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
            <div id="div-duracion" style="display:none; background:#FFF8E1; border-radius:14px; padding:14px 18px; margin-bottom:20px;">
                <p style="font-size:13px; color:#E65100; font-weight:600; display:flex; align-items:center; gap:6px; margin:0 0 4px;">
                    <i class="ti ti-clock" style="font-size:14px;"></i> Duración estimada: <span id="texto-duracion"></span>
                </p>
                <p style="font-size:13px; color:#E65100; font-weight:600; display:flex; align-items:center; gap:6px; margin:0;">
                    <i class="ti ti-coin" style="font-size:14px;"></i> Precio: Bs. <span id="texto-precio"></span>
                </p>
                <div id="aviso-temperamento" style="display:none; margin-top:8px; padding:8px 12px; background:#FFEBEE; border-radius:10px;">
                    <i class="ti ti-alert-triangle" style="font-size:12px; color:#C62828;"></i>
                    <span style="font-size:11px; color:#C62828; font-weight:500;"></span>
                </div>
            </div>

            {{-- Groomer --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-user" style="font-size:12px;"></i> Groomer preferido
                    <span style="color:#8A9B8A; font-weight:400;">(opcional)</span>
                </label>
                <select name="groomer_id"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                    <option value="">Sin preferencia (asignación automática)</option>
                    @foreach($groomers as $groomer)
                        <option value="{{ $groomer->id }}" {{ old('groomer_id') == $groomer->id ? 'selected' : '' }}>
                            {{ $groomer->nombre }} {{ $groomer->especialidad ? '— '.$groomer->especialidad : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fecha y hora --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-calendar" style="font-size:12px;"></i> Fecha *
                    </label>
                    <input type="date" name="fecha" value="{{ old('fecha') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        required>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-clock" style="font-size:12px;"></i> Hora *
                    </label>
                    <select name="hora"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
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
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-notes" style="font-size:12px;"></i> Notas adicionales
                    <span style="color:#8A9B8A; font-weight:400;">(opcional)</span>
                </label>
                <textarea name="notas_cliente" rows="3"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                    placeholder="Ej: Mi mascota es nerviosa, por favor tener cuidado...">{{ old('notas_cliente') }}</textarea>
            </div>

            <div style="display:flex; gap:14px;">
                <a href="{{ route('cliente.citas.index') }}"
                    style="flex:1; text-align:center; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:14px;"></i> Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="ti ti-calendar-plus" style="font-size:14px;"></i> Solicitar Cita
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

    let avisoHTML = '';
    let avisoVisible = false;
    if (temperamento === 'agresivo' || temperamento === 'nervioso') {
        durFinal = Math.ceil(durFinal * 1.20);
        avisoHTML = `<i class="ti ti-alert-triangle" style="font-size:12px;"></i> Se agregó 20% de tiempo extra por temperamento ${temperamento}.`;
        avisoVisible = true;
    }

    document.getElementById('texto-duracion').textContent = durFinal + ' minutos';
    document.getElementById('texto-precio').textContent   = precio.toFixed(2);
    
    const avisoDiv = document.getElementById('aviso-temperamento');
    if (avisoVisible && avisoDiv) {
        avisoDiv.style.display = 'flex';
        avisoDiv.style.alignItems = 'center';
        avisoDiv.style.gap = '6px';
        avisoDiv.querySelector('span').textContent = avisoHTML;
    } else if (avisoDiv) {
        avisoDiv.style.display = 'none';
    }
    
    divDuracion.style.display = 'block';
}
</script>

@endsection