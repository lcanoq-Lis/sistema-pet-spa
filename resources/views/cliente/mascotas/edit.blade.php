@extends('layouts.dashboard')

@section('page-title', '✏️ Editar Mascota')
@section('page-subtitle', 'Actualiza el perfil de tu mascota')

@section('content')
<div style="max-width:600px; margin:0 auto;">
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

        <form method="POST" action="{{ route('cliente.mascotas.update', $mascota->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $mascota->nombre) }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Especie *</label>
                    <select name="especie" style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;" required>
                        <option value="perro" {{ $mascota->especie === 'perro' ? 'selected' : '' }}>🐶 Perro</option>
                        <option value="gato"  {{ $mascota->especie === 'gato'  ? 'selected' : '' }}>🐱 Gato</option>
                        <option value="otro"  {{ $mascota->especie === 'otro'  ? 'selected' : '' }}>🐾 Otro</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Raza</label>
                    <input type="text" name="raza" value="{{ old('raza', $mascota->raza) }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Tamaño *</label>
                    <select name="tamano" style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;" required>
                        <option value="xs" {{ $mascota->tamano === 'xs' ? 'selected' : '' }}>XS - Muy pequeño</option>
                        <option value="s"  {{ $mascota->tamano === 's'  ? 'selected' : '' }}>S - Pequeño</option>
                        <option value="m"  {{ $mascota->tamano === 'm'  ? 'selected' : '' }}>M - Mediano</option>
                        <option value="l"  {{ $mascota->tamano === 'l'  ? 'selected' : '' }}>L - Grande</option>
                        <option value="xl" {{ $mascota->tamano === 'xl' ? 'selected' : '' }}>XL - Gigante</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Peso (kg)</label>
                    <input type="number" name="peso_kg" value="{{ old('peso_kg', $mascota->peso_kg) }}" step="0.1" min="0"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $mascota->fecha_nacimiento?->format('Y-m-d')) }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Temperamento</label>
                    <select name="temperamento" style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                        <option value="">Selecciona...</option>
                        <option value="tranquilo" {{ $mascota->temperamento === 'tranquilo' ? 'selected' : '' }}>😊 Tranquilo</option>
                        <option value="jugueton"  {{ $mascota->temperamento === 'jugueton'  ? 'selected' : '' }}>🎾 Juguetón</option>
                        <option value="nervioso"  {{ $mascota->temperamento === 'nervioso'  ? 'selected' : '' }}>😰 Nervioso</option>
                        <option value="agresivo"  {{ $mascota->temperamento === 'agresivo'  ? 'selected' : '' }}>😠 Agresivo</option>
                        <option value="otro"      {{ $mascota->temperamento === 'otro'      ? 'selected' : '' }}>🐾 Otro</option>
                    </select>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Alergias</label>
                    <textarea name="alergias" rows="2"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;">{{ old('alergias', $mascota->alergias) }}</textarea>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Restricciones médicas</label>
                    <textarea name="restricciones_medicas" rows="2"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;">{{ old('restricciones_medicas', $mascota->restricciones_medicas) }}</textarea>
                </div>

            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <a href="{{ route('cliente.mascotas.index') }}"
                    style="flex:1; text-align:center; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
                    ← Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Guardar cambios ✓
                </button>
            </div>
        </form>
    </div>
</div>
@endsection