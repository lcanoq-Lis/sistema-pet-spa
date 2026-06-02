@extends('layouts.dashboard')

@section('page-title', 'Editar Mascota')
@section('page-subtitle', 'Actualiza el perfil de tu mascota')

@section('content')
<div style="max-width:600px; margin:0 auto;">
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

        <form method="POST" action="{{ route('cliente.mascotas.update', $mascota->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-dog" style="font-size:12px;"></i> Nombre *
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $mascota->nombre) }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'" required>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-category" style="font-size:12px;"></i> Especie *
                    </label>
                    <select name="especie"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'" required>
                        <option value="perro" {{ $mascota->especie === 'perro' ? 'selected' : '' }}>Perro</option>
                        <option value="gato"  {{ $mascota->especie === 'gato'  ? 'selected' : '' }}>Gato</option>
                        <option value="otro"  {{ $mascota->especie === 'otro'  ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-heart" style="font-size:12px;"></i> Raza
                    </label>
                    <input type="text" name="raza" value="{{ old('raza', $mascota->raza) }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-ruler" style="font-size:12px;"></i> Tamaño *
                    </label>
                    <select name="tamano"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'" required>
                        <option value="xs" {{ $mascota->tamano === 'xs' ? 'selected' : '' }}>XS - Muy pequeño</option>
                        <option value="s"  {{ $mascota->tamano === 's'  ? 'selected' : '' }}>S - Pequeño</option>
                        <option value="m"  {{ $mascota->tamano === 'm'  ? 'selected' : '' }}>M - Mediano</option>
                        <option value="l"  {{ $mascota->tamano === 'l'  ? 'selected' : '' }}>L - Grande</option>
                        <option value="xl" {{ $mascota->tamano === 'xl' ? 'selected' : '' }}>XL - Gigante</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-weight" style="font-size:12px;"></i> Peso (kg)
                    </label>
                    <input type="number" name="peso_kg" value="{{ old('peso_kg', $mascota->peso_kg) }}" step="0.1" min="0"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-cake" style="font-size:12px;"></i> Fecha de nacimiento
                    </label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento', $mascota->fecha_nacimiento?->format('Y-m-d')) }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-mood-smile" style="font-size:12px;"></i> Temperamento
                    </label>
                    <select name="temperamento"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                        <option value="">Selecciona...</option>
                        <option value="tranquilo" {{ $mascota->temperamento === 'tranquilo' ? 'selected' : '' }}>Tranquilo</option>
                        <option value="jugueton"  {{ $mascota->temperamento === 'jugueton'  ? 'selected' : '' }}>Juguetón</option>
                        <option value="nervioso"  {{ $mascota->temperamento === 'nervioso'  ? 'selected' : '' }}>Nervioso</option>
                        <option value="agresivo"  {{ $mascota->temperamento === 'agresivo'  ? 'selected' : '' }}>Agresivo</option>
                        <option value="otro"      {{ $mascota->temperamento === 'otro'      ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-alert-triangle" style="font-size:12px;"></i> Alergias
                    </label>
                    <textarea name="alergias" rows="2"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">{{ old('alergias', $mascota->alergias) }}</textarea>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-notes-medical" style="font-size:12px;"></i> Restricciones médicas
                    </label>
                    <textarea name="restricciones_medicas" rows="2"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">{{ old('restricciones_medicas', $mascota->restricciones_medicas) }}</textarea>
                </div>

            </div>

            <div style="display:flex; gap:14px; margin-top:28px;">
                <a href="{{ route('cliente.mascotas.index') }}"
                    style="flex:1; text-align:center; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:14px;"></i> Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="ti ti-device-floppy" style="font-size:14px;"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection