@extends('layouts.dashboard')

@section('page-title', '➕ Nueva Mascota')
@section('page-subtitle', 'Registra el perfil de tu mascota')

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

        <form method="POST" action="{{ route('cliente.mascotas.store') }}">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nombre de la mascota *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        placeholder="Ej: Max, Luna..." required>
                </div>

                <div>
    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Especie *</label>
    <select name="especie" id="select-especie"
        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
        onchange="mostrarOtroEspecie(this)" required>
        <option value="">Selecciona...</option>
        <option value="perro" {{ old('especie') === 'perro' ? 'selected' : '' }}>🐶 Perro</option>
        <option value="gato"  {{ old('especie') === 'gato'  ? 'selected' : '' }}>🐱 Gato</option>
        <option value="otro"  {{ old('especie') === 'otro'  ? 'selected' : '' }}>🐾 Otro</option>
    </select>
</div>

{{-- Campo que aparece solo cuando selecciona "Otro" --}}
<div id="div-otro-especie" style="display:{{ old('especie') === 'otro' ? 'block' : 'none' }};">
    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Especifica la especie *</label>
    <input type="text" name="especie_otro" value="{{ old('especie_otro') }}"
        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
        placeholder="Ej: Conejo, Pájaro, Hamster...">
</div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Raza</label>
                    <input type="text" name="raza" value="{{ old('raza') }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        placeholder="Ej: Golden Retriever">
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Tamaño *</label>
                    <select name="tamano"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                        <option value="">Selecciona...</option>
                        <option value="xs" {{ old('tamano') === 'xs' ? 'selected' : '' }}>XS - Muy pequeño</option>
                        <option value="s"  {{ old('tamano') === 's'  ? 'selected' : '' }}>S - Pequeño</option>
                        <option value="m"  {{ old('tamano') === 'm'  ? 'selected' : '' }}>M - Mediano</option>
                        <option value="l"  {{ old('tamano') === 'l'  ? 'selected' : '' }}>L - Grande</option>
                        <option value="xl" {{ old('tamano') === 'xl' ? 'selected' : '' }}>XL - Gigante</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Peso (kg)</label>
                    <input type="number" name="peso_kg" value="{{ old('peso_kg') }}" step="0.1" min="0"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        placeholder="Ej: 5.5">
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Fecha de nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                </div>

                <div>
    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Temperamento</label>
    <select name="temperamento" id="select-temperamento"
        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
        onchange="mostrarOtroTemperamento(this)">
        <option value="">Selecciona...</option>
        <option value="tranquilo" {{ old('temperamento') === 'tranquilo' ? 'selected' : '' }}>😊 Tranquilo</option>
        <option value="jugueton"  {{ old('temperamento') === 'jugueton'  ? 'selected' : '' }}>🎾 Juguetón</option>
        <option value="nervioso"  {{ old('temperamento') === 'nervioso'  ? 'selected' : '' }}>😰 Nervioso</option>
        <option value="agresivo"  {{ old('temperamento') === 'agresivo'  ? 'selected' : '' }}>😠 Agresivo</option>
        <option value="otro"      {{ old('temperamento') === 'otro'      ? 'selected' : '' }}>🐾 Otro</option>
    </select>
</div>

{{-- Campo que aparece solo cuando selecciona "Otro" en temperamento --}}
<div id="div-otro-temperamento" style="display:{{ old('temperamento') === 'otro' ? 'block' : 'none' }}; grid-column:span 2;">
    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Especifica el temperamento</label>
    <input type="text" name="temperamento_otro" value="{{ old('temperamento_otro') }}"
        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
        placeholder="Ej: Tímido, hiperactivo...">
</div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Alergias conocidas</label>
                    <textarea name="alergias" rows="2"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                        placeholder="Ej: Alérgico al shampoo de avena...">{{ old('alergias') }}</textarea>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Restricciones médicas</label>
                    <textarea name="restricciones_medicas" rows="2"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                        placeholder="Ej: No puede estar más de 2 horas...">{{ old('restricciones_medicas') }}</textarea>
                </div>

            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <a href="{{ route('cliente.mascotas.index') }}"
                    style="flex:1; text-align:center; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
                    ← Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Registrar Mascota 🐾
                </button>
            </div>
        </form>
    </div>
</div>
<script>
function mostrarOtroEspecie(select) {
    const div = document.getElementById('div-otro-especie');
    const input = div.querySelector('input');
    if (select.value === 'otro') {
        div.style.display = 'block';
        input.required = true;
    } else {
        div.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}
function mostrarOtroTemperamento(select) {
    const div = document.getElementById('div-otro-temperamento');
    const input = div.querySelector('input');
    if (select.value === 'otro') {
        div.style.display = 'block';
    } else {
        div.style.display = 'none';
        input.value = '';
    }
}
</script>
@endsection