@extends('layouts.dashboard')
@section('page-title', '🐾 Registrar Mascota')
@section('page-subtitle', 'Agregar mascota para {{ $cliente->nombre }}')

@section('content')
<div style="max-width:560px; margin:0 auto;">

@if($errors->any())
    <div class="alert alert-error">❌ {{ $errors->first() }}</div>
@endif

<div class="card" style="margin-bottom:16px; background:linear-gradient(135deg,#ff7043,#ff8f00); border:none;">
    <div style="display:flex; align-items:center; gap:12px;">
        <div style="background:rgba(255,255,255,0.2); border-radius:50%; width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:24px;">👤</div>
        <div>
            <p style="font-size:13px; color:rgba(255,255,255,0.8); margin:0;">Registrando mascota para</p>
            <p style="font-size:16px; font-weight:700; color:white; margin:0;">{{ $cliente->nombre }}</p>
        </div>
    </div>
</div>

<div class="card">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); margin:-22px -22px 20px; padding:16px 20px; border-radius:14px 14px 0 0; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">🐾</span>
        <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Datos de la mascota</h3>
    </div>

    <form method="POST" action="{{ route('recepcion.clientes.mascota.store', $cliente->id) }}">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label class="form-label">Nombre *</label>
                <input type="text" name="nombre" class="form-input" required value="{{ old('nombre') }}" placeholder="Max, Luna...">
            </div>
            <div>
                <label class="form-label">Especie *</label>
                <select name="especie" class="form-input form-select" required>
                    <option value="">— Seleccionar —</option>
                    <option value="perro" {{ old('especie') === 'perro' ? 'selected' : '' }}>🐶 Perro</option>
                    <option value="gato" {{ old('especie') === 'gato' ? 'selected' : '' }}>🐱 Gato</option>
                    <option value="conejo" {{ old('especie') === 'conejo' ? 'selected' : '' }}>🐰 Conejo</option>
                    <option value="hamster" {{ old('especie') === 'hamster' ? 'selected' : '' }}>🐹 Hámster</option>
                    <option value="ave" {{ old('especie') === 'ave' ? 'selected' : '' }}>🐦 Ave</option>
                    <option value="otro" {{ old('especie') === 'otro' ? 'selected' : '' }}>🐾 Otro</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label class="form-label">Raza</label>
                <input type="text" name="raza" class="form-input" value="{{ old('raza') }}" placeholder="Labrador, Persa...">
            </div>
            <div>
                <label class="form-label">Tamaño *</label>
                <select name="tamano" class="form-input form-select" required>
                    <option value="">— Seleccionar —</option>
                    <option value="xs">XS — Mini</option>
                    <option value="s">S — Pequeño</option>
                    <option value="m">M — Mediano</option>
                    <option value="l">L — Grande</option>
                    <option value="xl">XL — Extra grande</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label class="form-label">Peso (kg)</label>
                <input type="number" name="peso_kg" class="form-input" step="0.1" min="0.1" value="{{ old('peso_kg') }}" placeholder="5.5">
            </div>
            <div>
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" name="fecha_nacimiento" class="form-input" value="{{ old('fecha_nacimiento') }}">
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label class="form-label">Temperamento</label>
            <input type="text" name="temperamento" class="form-input" value="{{ old('temperamento') }}" placeholder="Tranquilo, nervioso, agresivo...">
        </div>

        <div style="margin-bottom:14px;">
            <label class="form-label">Alergias</label>
            <input type="text" name="alergias" class="form-input" value="{{ old('alergias') }}" placeholder="Al polen, shampoos con perfume...">
        </div>

        <div style="margin-bottom:20px;">
            <label class="form-label">Restricciones médicas</label>
            <textarea name="restricciones_medicas" class="form-input" rows="2" placeholder="No puede mojarse, medicación activa...">{{ old('restricciones_medicas') }}</textarea>
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('recepcion.clientes.show', $cliente->id) }}" class="btn btn-secondary" style="flex:1; text-align:center;">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary" style="flex:2;">
                🐾 Registrar mascota
            </button>
        </div>
    </form>
</div>
</div>
@endsection
