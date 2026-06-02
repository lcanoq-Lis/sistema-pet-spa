@extends('layouts.dashboard')

@section('page-title', 'Promociones')
@section('page-subtitle', 'Gestiona descuentos y beneficios para clientes')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; color:#2E7D32; border-left:4px solid #43A047; padding:14px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="font-size:18px;"></i> {{ session('status') }}
    </div>
@endif

<div style="display:grid; grid-template-columns:1fr 1.4fr; gap:24px; align-items:start;">

    {{-- FORMULARIO CREAR --}}
    <div class="stat-card" style="padding:0; overflow:hidden; border-radius:24px;">
        <div style="background:linear-gradient(135deg,#2E7D32,#43A047); padding:18px 24px; display:flex; align-items:center; gap:12px;">
            <i class="ti ti-ticket" style="font-size:22px; color:white;"></i>
            <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Nueva promoción</h3>
        </div>

        <div style="padding:24px;">
            <form method="POST" action="{{ route('admin.promociones.store') }}">
                @csrf

                {{-- Nombre --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-tag" style="font-size:14px;"></i> Nombre *
                    </label>
                    <input type="text" name="nombre" required maxlength="150"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; transition:all 0.2s;"
                        placeholder="Ej: Descuento bienvenida, Promo verano..." value="{{ old('nombre') }}">
                </div>

                {{-- Descripción --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-notes" style="font-size:14px;"></i> Descripción
                    </label>
                    <textarea name="descripcion" rows="2"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; resize:vertical;"
                        placeholder="Detalle de la promoción...">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Tipo de descuento --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-discount" style="font-size:14px;"></i> Tipo de descuento *
                    </label>
                    <select name="tipo" required onchange="actualizarTipo(this.value)"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; background:white;">
                        <option value="">— Seleccionar —</option>
                        <option value="porcentaje" {{ old('tipo') == 'porcentaje' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="monto_fijo" {{ old('tipo') == 'monto_fijo' ? 'selected' : '' }}>Monto fijo (Bs.)</option>
                        <option value="cliente_frecuente" {{ old('tipo') == 'cliente_frecuente' ? 'selected' : '' }}>Cliente frecuente (%)</option>
                    </select>
                </div>

                {{-- Valor y mínimo de citas --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:18px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;" id="label-valor">
                            <i class="ti ti-chart-line"></i> Valor *
                        </label>
                        <input type="number" name="valor" required min="0.01" step="0.01"
                            style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                            placeholder="10" value="{{ old('valor') }}">
                    </div>
                    <div id="campo-min-citas" style="display: {{ old('tipo') == 'cliente_frecuente' ? 'block' : 'none' }};">
                        <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="ti ti-calendar-check"></i> Mín. citas completadas
                        </label>
                        <input type="number" name="min_citas" min="1"
                            style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                            placeholder="5" value="{{ old('min_citas') }}">
                    </div>
                </div>

                {{-- Servicio específico --}}
                <div style="margin-bottom:18px;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-scissors"></i> Servicio específico
                        <span style="color:#A1887F; font-weight:400; text-transform:none;">(vacío = todos)</span>
                    </label>
                    <select name="servicio_id"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; background:white;">
                        <option value="">Todos los servicios</option>
                        @foreach($servicios as $s)
                            <option value="{{ $s->id }}" {{ old('servicio_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Fechas --}}
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
                    <div>
                        <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="ti ti-calendar-event"></i> Fecha inicio
                        </label>
                        <input type="date" name="fecha_inicio"
                            style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                            value="{{ old('fecha_inicio') }}">
                    </div>
                    <div>
                        <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                            <i class="ti ti-calendar-event"></i> Fecha fin
                        </label>
                        <input type="date" name="fecha_fin"
                            style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                            value="{{ old('fecha_fin') }}">
                    </div>
                </div>

                {{-- Botón submit --}}
                <button type="submit"
                    style="width:100%; background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:700; padding:14px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-device-floppy"></i> Crear promoción
                </button>
            </form>
        </div>
    </div>

    {{-- LISTA DE PROMOCIONES --}}
    <div class="stat-card" style="padding:0; overflow:hidden; border-radius:24px;">
        <div style="background:linear-gradient(135deg,#2E7D32,#43A047); padding:18px 24px; display:flex; align-items:center; gap:12px;">
            <i class="ti ti-list" style="font-size:22px; color:white;"></i>
            <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Promociones registradas</h3>
            <span style="margin-left:auto; background:rgba(255,255,255,0.2); border-radius:40px; padding:4px 14px; font-size:12px; color:white; font-weight:600;">
                {{ $promociones->count() }}
            </span>
        </div>

        @if($promociones->isEmpty())
            <div style="padding:60px; text-align:center;">
                <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                    <i class="ti ti-ticket-off" style="font-size:48px; color:#A1887F;"></i>
                    <p style="color:#A1887F; margin:0;">No hay promociones registradas aún.</p>
                </div>
            </div>
        @else
            <div style="padding:20px; display:flex; flex-direction:column; gap:12px;">
                @foreach($promociones as $promo)
                    @php $vigente = $promo->estaVigente(); @endphp
                    <div style="border:1px solid #E0D6CC; border-radius:16px; padding:16px; background:{{ $vigente ? '#F9FDF5' : '#FAFAFA' }}; transition:all 0.2s;">
                        {{-- Header de promoción --}}
                        <div style="display:flex; align-items:start; justify-content:space-between; gap:12px; margin-bottom:10px; flex-wrap:wrap;">
                            <div>
                                <p style="font-size:15px; font-weight:700; color:#5D4037; margin:0; display:flex; align-items:center; gap:8px;">
                                    <i class="ti ti-ticket" style="color:#2E7D32; font-size:16px;"></i>
                                    {{ $promo->nombre }}
                                </p>
                                <p style="font-size:12px; color:#A1887F; margin:4px 0 0;">{{ $promo->tipo_label }}</p>
                                @if($promo->descripcion)
                                    <p style="font-size:12px; color:#A1887F; margin:6px 0 0;">{{ $promo->descripcion }}</p>
                                @endif
                            </div>
                            <span style="background:{{ $vigente ? '#E8F5E9' : '#FAFAFA' }}; color:{{ $vigente ? '#2E7D32' : '#A1887F' }}; border:1px solid {{ $vigente ? '#A5D6A7' : '#D7CCC8' }}; border-radius:40px; padding:4px 12px; font-size:11px; font-weight:600; white-space:nowrap; display:inline-flex; align-items:center; gap:6px;">
                                <i class="ti {{ $vigente ? 'ti-circle-check' : 'ti-circle-x' }}" style="font-size:10px;"></i>
                                {{ $vigente ? 'Activa' : 'Inactiva' }}
                            </span>
                        </div>

                        {{-- Badges --}}
                        <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:14px;">
                            @if($promo->servicio)
                                <span style="background:#E8F5E9; color:#2E7D32; padding:4px 12px; border-radius:40px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                                    <i class="ti ti-scissors" style="font-size:11px;"></i> {{ $promo->servicio->nombre }}
                                </span>
                            @else
                                <span style="background:#F5F0EB; color:#8D6E63; padding:4px 12px; border-radius:40px; font-size:11px; display:inline-flex; align-items:center; gap:6px;">
                                    <i class="ti ti-paw" style="font-size:11px;"></i> Todos los servicios
                                </span>
                            @endif

                            @if($promo->fecha_inicio || $promo->fecha_fin)
                                <span style="background:#E8F5E9; color:#2E7D32; padding:4px 12px; border-radius:40px; font-size:11px; display:inline-flex; align-items:center; gap:6px;">
                                    <i class="ti ti-calendar" style="font-size:11px;"></i>
                                    {{ $promo->fecha_inicio?->format('d/m/Y') ?? '—' }} → {{ $promo->fecha_fin?->format('d/m/Y') ?? '—' }}
                                </span>
                            @endif

                            @if($promo->min_citas)
                                <span style="background:#E8F5E9; color:#2E7D32; padding:4px 12px; border-radius:40px; font-size:11px; display:inline-flex; align-items:center; gap:6px;">
                                    <i class="ti ti-star" style="font-size:11px;"></i> Mín. {{ $promo->min_citas }} citas
                                </span>
                            @endif
                        </div>

                        {{-- Botones de acción --}}
                        <div style="display:flex; gap:10px;">
                            <form method="POST" action="{{ route('admin.promociones.toggle', $promo->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    style="background:#E8F5E9; color:#2E7D32; padding:6px 16px; border-radius:40px; border:none; cursor:pointer; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                                    <i class="ti {{ $vigente ? 'ti-player-pause' : 'ti-player-play' }}" style="font-size:11px;"></i>
                                    {{ $vigente ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.promociones.destroy', $promo->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar esta promoción?')"
                                    style="background:#FFEBEE; color:#C62828; padding:6px 16px; border-radius:40px; border:none; cursor:pointer; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                                    <i class="ti ti-trash" style="font-size:11px;"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
function actualizarTipo(tipo) {
    const labelValor    = document.getElementById('label-valor');
    const campoMinCitas = document.getElementById('campo-min-citas');
    
    if (tipo === 'porcentaje' || tipo === 'cliente_frecuente') {
        labelValor.innerHTML = '<i class="ti ti-chart-line"></i> ' + (tipo === 'porcentaje' ? 'Porcentaje (%) *' : 'Porcentaje para frecuentes (%) *');
    } else {
        labelValor.innerHTML = '<i class="ti ti-coin"></i> Monto fijo (Bs.) *';
    }
    
    campoMinCitas.style.display = tipo === 'cliente_frecuente' ? 'block' : 'none';
}
</script>

@endsection