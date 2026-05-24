@extends('layouts.dashboard')
@section('page-title', '🏷️ Promociones')
@section('page-subtitle', 'Gestiona descuentos y beneficios para clientes')

@section('content')

@if(session('status'))
    <div class="alert alert-success">✅ {{ session('status') }}</div>
@endif

<div style="display:grid; grid-template-columns:1fr 1.4fr; gap:20px; align-items:start;">

{{-- FORMULARIO CREAR --}}
<div class="card">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); margin:-22px -22px 20px; padding:16px 20px; border-radius:14px 14px 0 0; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">🏷️</span>
        <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Nueva promoción</h3>
    </div>

    <form method="POST" action="{{ route('admin.promociones.store') }}">
        @csrf

        <div style="margin-bottom:14px;">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" class="form-input" required maxlength="150"
                placeholder="Ej: Descuento bienvenida, Promo verano...">
        </div>

        <div style="margin-bottom:14px;">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-input" rows="2"
                placeholder="Detalle de la promoción..."></textarea>
        </div>

        <div style="margin-bottom:14px;">
            <label class="form-label">Tipo de descuento *</label>
            <select name="tipo" class="form-input form-select" required onchange="actualizarTipo(this.value)">
                <option value="">— Seleccionar —</option>
                <option value="porcentaje">🏷️ Porcentaje (%)</option>
                <option value="monto_fijo">💵 Monto fijo (Bs.)</option>
                <option value="cliente_frecuente">⭐ Cliente frecuente (%)</option>
            </select>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
            <div>
                <label class="form-label" id="label-valor">Valor *</label>
                <input type="number" name="valor" class="form-input" required min="0.01" step="0.01"
                    placeholder="10">
            </div>
            <div id="campo-min-citas" style="display:none;">
                <label class="form-label">Mín. citas completadas</label>
                <input type="number" name="min_citas" class="form-input" min="1" placeholder="5">
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label class="form-label">Servicio específico <span style="color:var(--text-muted); font-weight:400; text-transform:none;">(vacío = todos)</span></label>
            <select name="servicio_id" class="form-input form-select">
                <option value="">🐾 Todos los servicios</option>
                @foreach($servicios as $s)
                    <option value="{{ $s->id }}">{{ $s->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px;">
            <div>
                <label class="form-label">Fecha inicio</label>
                <input type="date" name="fecha_inicio" class="form-input">
            </div>
            <div>
                <label class="form-label">Fecha fin</label>
                <input type="date" name="fecha_fin" class="form-input">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;">
            ✅ Crear promoción
        </button>
    </form>
</div>

{{-- LISTA DE PROMOCIONES --}}
<div class="card" style="padding:0; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); padding:16px 20px; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">📋</span>
        <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Promociones registradas</h3>
        <span style="margin-left:auto; background:rgba(255,255,255,0.2); border-radius:20px; padding:3px 12px; font-size:12px; color:white; font-weight:600;">
            {{ $promociones->count() }}
        </span>
    </div>

    @if($promociones->isEmpty())
        <div style="padding:40px; text-align:center; color:var(--text-muted);">
            <div style="font-size:40px; margin-bottom:12px;">🏷️</div>
            No hay promociones registradas aún.
        </div>
    @else
        <div style="padding:16px; display:flex; flex-direction:column; gap:10px;">
            @foreach($promociones as $promo)
            @php $vigente = $promo->estaVigente(); @endphp
            <div style="border:1px solid var(--border); border-radius:12px; padding:14px; background:{{ $vigente ? '#f9fdf5' : '#fafafa' }};">
                <div style="display:flex; align-items:start; justify-content:space-between; gap:10px; margin-bottom:8px;">
                    <div>
                        <p style="font-size:14px; font-weight:700; color:var(--text); margin:0;">{{ $promo->nombre }}</p>
                        <p style="font-size:12px; color:var(--text-muted); margin:2px 0 0;">{{ $promo->tipo_label }}</p>
                        @if($promo->descripcion)
                            <p style="font-size:12px; color:var(--text-muted); margin:4px 0 0;">{{ $promo->descripcion }}</p>
                        @endif
                    </div>
                    <span style="background:{{ $vigente ? '#e8f5e9' : '#fafafa' }}; color:{{ $vigente ? '#2e7d32' : '#a1887f' }}; border:1px solid {{ $vigente ? '#a5d6a7' : '#d7ccc8' }}; border-radius:20px; padding:3px 10px; font-size:11px; font-weight:600; white-space:nowrap; flex-shrink:0;">
                        {{ $vigente ? '● Activa' : '● Inactiva' }}
                    </span>
                </div>

                <div style="display:flex; flex-wrap:wrap; gap:6px; margin-bottom:10px;">
                    @if($promo->servicio)
                        <span style="background:#e3f2fd; color:#1565c0; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">
                            ✂️ {{ $promo->servicio->nombre }}
                        </span>
                    @else
                        <span style="background:#f5f0eb; color:#8d6e63; padding:2px 8px; border-radius:10px; font-size:11px;">
                            🐾 Todos los servicios
                        </span>
                    @endif
                    @if($promo->fecha_inicio || $promo->fecha_fin)
                        <span style="background:#fff3e0; color:#e65100; padding:2px 8px; border-radius:10px; font-size:11px;">
                            📅 {{ $promo->fecha_inicio?->format('d/m/Y') ?? '—' }} → {{ $promo->fecha_fin?->format('d/m/Y') ?? '—' }}
                        </span>
                    @endif
                    @if($promo->min_citas)
                        <span style="background:#f3e5f5; color:#6a1b9a; padding:2px 8px; border-radius:10px; font-size:11px;">
                            ⭐ Mín. {{ $promo->min_citas }} citas
                        </span>
                    @endif
                </div>

                <div style="display:flex; gap:8px;">
                    <form method="POST" action="{{ route('admin.promociones.toggle', $promo->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-secondary" style="font-size:12px; padding:5px 12px;">
                            {{ $vigente ? '⏸ Desactivar' : '▶ Activar' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.promociones.destroy', $promo->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('¿Eliminar esta promoción?')"
                            class="btn btn-danger" style="font-size:12px; padding:5px 12px;">
                            ✕ Eliminar
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
        labelValor.textContent = tipo === 'porcentaje' ? 'Porcentaje (%) *' : 'Porcentaje para frecuentes (%) *';
    } else {
        labelValor.textContent = 'Monto fijo (Bs.) *';
    }
    campoMinCitas.style.display = tipo === 'cliente_frecuente' ? 'block' : 'none';
}
</script>
@endsection
