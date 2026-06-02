@extends('layouts.dashboard')

@section('page-title', 'Nueva Mascota')
@section('page-subtitle', 'Registra el perfil de tu mascota')

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

        <form method="POST" action="{{ route('cliente.mascotas.store') }}">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-dog" style="font-size:12px;"></i> Nombre de la mascota *
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: Max, Luna..." required>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-category" style="font-size:12px;"></i> Especie *
                    </label>
                    <select name="especie" id="select-especie" onchange="mostrarOtroEspecie(this)"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'" required>
                        <option value="">Selecciona...</option>
                        <option value="perro" {{ old('especie') === 'perro' ? 'selected' : '' }}>Perro</option>
                        <option value="gato"  {{ old('especie') === 'gato'  ? 'selected' : '' }}>Gato</option>
                        <option value="otro"  {{ old('especie') === 'otro'  ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div id="div-otro-especie" style="display:{{ old('especie') === 'otro' ? 'block' : 'none' }};">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-edit" style="font-size:12px;"></i> Especifica la especie *
                    </label>
                    <input type="text" name="especie_otro" value="{{ old('especie_otro') }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: Conejo, Pájaro, Hamster...">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-heart" style="font-size:12px;"></i> Raza
                    </label>
                    <input type="text" name="raza" value="{{ old('raza') }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: Golden Retriever">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-ruler" style="font-size:12px;"></i> Tamaño *
                    </label>
                    <select name="tamano"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'" required>
                        <option value="">Selecciona...</option>
                        <option value="xs" {{ old('tamano') === 'xs' ? 'selected' : '' }}>XS - Muy pequeño</option>
                        <option value="s"  {{ old('tamano') === 's'  ? 'selected' : '' }}>S - Pequeño</option>
                        <option value="m"  {{ old('tamano') === 'm'  ? 'selected' : '' }}>M - Mediano</option>
                        <option value="l"  {{ old('tamano') === 'l'  ? 'selected' : '' }}>L - Grande</option>
                        <option value="xl" {{ old('tamano') === 'xl' ? 'selected' : '' }}>XL - Gigante</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-weight" style="font-size:12px;"></i> Peso (kg)
                    </label>
                    <input type="number" name="peso_kg" value="{{ old('peso_kg') }}" step="0.1" min="0"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: 5.5">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-cake" style="font-size:12px;"></i> Fecha de nacimiento
                    </label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-mood-smile" style="font-size:12px;"></i> Temperamento
                    </label>
                    <select name="temperamento" id="select-temperamento" onchange="mostrarOtroTemperamento(this)"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                        <option value="">Selecciona...</option>
                        <option value="tranquilo" {{ old('temperamento') === 'tranquilo' ? 'selected' : '' }}>Tranquilo</option>
                        <option value="jugueton"  {{ old('temperamento') === 'jugueton'  ? 'selected' : '' }}>Juguetón</option>
                        <option value="nervioso"  {{ old('temperamento') === 'nervioso'  ? 'selected' : '' }}>Nervioso</option>
                        <option value="agresivo"  {{ old('temperamento') === 'agresivo'  ? 'selected' : '' }}>Agresivo</option>
                        <option value="otro"      {{ old('temperamento') === 'otro'      ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div id="div-otro-temperamento" style="display:{{ old('temperamento') === 'otro' ? 'block' : 'none' }}; grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-edit" style="font-size:12px;"></i> Especifica el temperamento
                    </label>
                    <input type="text" name="temperamento_otro" value="{{ old('temperamento_otro') }}"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: Tímido, hiperactivo...">
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-alert-triangle" style="font-size:12px;"></i> Alergias conocidas
                    </label>
                    <textarea name="alergias" rows="2"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: Alérgico al shampoo de avena...">{{ old('alergias') }}</textarea>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                        <i class="ti ti-notes-medical" style="font-size:12px;"></i> Restricciones médicas
                    </label>
                    <textarea name="restricciones_medicas" rows="2"
                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s;"
                        onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"
                        placeholder="Ej: No puede estar más de 2 horas...">{{ old('restricciones_medicas') }}</textarea>
                </div>

            </div>

            <div style="display:flex; gap:14px; margin-top:28px;">
                <a href="{{ route('cliente.mascotas.index') }}"
                    style="flex:1; text-align:center; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:14px;"></i> Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="ti ti-paw" style="font-size:14px;"></i> Registrar Mascota
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