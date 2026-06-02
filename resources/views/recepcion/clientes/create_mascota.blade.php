@extends('layouts.dashboard')
@section('page-title', 'Registrar Mascota')
@section('page-subtitle', 'Agregar mascota para {{ $cliente->nombre }}')

@section('content')
<div style="max-width:600px; margin:0 auto;">

@if($errors->any())
    <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
        <p style="color:#C62828; font-size:13px; font-weight:500; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif

{{-- Tarjeta de información del cliente --}}
<div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); border-radius:20px; padding:20px 24px; margin-bottom:24px; display:flex; align-items:center; gap:16px;">
    <div style="width:52px; height:52px; background:rgba(255,255,255,0.15); border-radius:14px; display:flex; align-items:center; justify-content:center;">
        <i class="ti ti-user" style="font-size:26px; color:#fff;"></i>
    </div>
    <div>
        <p style="font-size:12px; color:#C8E6C9; margin:0;">Registrando mascota para</p>
        <p style="font-size:18px; font-weight:800; color:#fff; margin:4px 0 0;">{{ $cliente->nombre }}</p>
    </div>
</div>

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #FF7043, #F57F17); padding:16px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-paw" style="font-size:20px; color:#fff;"></i>
        </div>
        <h3 style="font-size:14px; font-weight:700; color:#fff; margin:0;">Datos de la mascota</h3>
    </div>

    <form method="POST" action="{{ route('recepcion.clientes.mascota.store', $cliente->id) }}" style="padding:24px;">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-dog" style="font-size:12px;"></i> Nombre *
                </label>
                <input type="text" name="nombre" required value="{{ old('nombre') }}" placeholder="Max, Luna..."
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-category" style="font-size:12px;"></i> Especie *
                </label>
                <select name="especie" required
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                    <option value="">— Seleccionar —</option>
                    <option value="perro" {{ old('especie') === 'perro' ? 'selected' : '' }}>Perro</option>
                    <option value="gato" {{ old('especie') === 'gato' ? 'selected' : '' }}>Gato</option>
                    <option value="conejo" {{ old('especie') === 'conejo' ? 'selected' : '' }}>Conejo</option>
                    <option value="hamster" {{ old('especie') === 'hamster' ? 'selected' : '' }}>Hámster</option>
                    <option value="ave" {{ old('especie') === 'ave' ? 'selected' : '' }}>Ave</option>
                    <option value="otro" {{ old('especie') === 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-heart" style="font-size:12px;"></i> Raza
                </label>
                <input type="text" name="raza" value="{{ old('raza') }}" placeholder="Labrador, Persa..."
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-ruler" style="font-size:12px;"></i> Tamaño *
                </label>
                <select name="tamano" required
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                    <option value="">— Seleccionar —</option>
                    <option value="xs" {{ old('tamano') === 'xs' ? 'selected' : '' }}>XS — Mini</option>
                    <option value="s" {{ old('tamano') === 's' ? 'selected' : '' }}>S — Pequeño</option>
                    <option value="m" {{ old('tamano') === 'm' ? 'selected' : '' }}>M — Mediano</option>
                    <option value="l" {{ old('tamano') === 'l' ? 'selected' : '' }}>L — Grande</option>
                    <option value="xl" {{ old('tamano') === 'xl' ? 'selected' : '' }}>XL — Extra grande</option>
                </select>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-weight" style="font-size:12px;"></i> Peso (kg)
                </label>
                <input type="number" name="peso_kg" step="0.1" min="0.1" value="{{ old('peso_kg') }}" placeholder="5.5"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-cake" style="font-size:12px;"></i> Fecha de nacimiento
                </label>
                <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-mood-smile" style="font-size:12px;"></i> Temperamento
            </label>
            <input type="text" name="temperamento" value="{{ old('temperamento') }}" placeholder="Tranquilo, nervioso, agresivo..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-alert-triangle" style="font-size:12px;"></i> Alergias
            </label>
            <input type="text" name="alergias" value="{{ old('alergias') }}" placeholder="Al polen, shampoos con perfume..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-notes-medical" style="font-size:12px;"></i> Restricciones médicas
            </label>
            <textarea name="restricciones_medicas" rows="2" placeholder="No puede mojarse, medicación activa..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; font-family:inherit; outline:none; resize:vertical; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">{{ old('restricciones_medicas') }}</textarea>
        </div>

        <div style="display:flex; gap:14px;">
            <a href="{{ route('recepcion.clientes.show', $cliente->id) }}" 
                style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; text-align:center; display:inline-flex; align-items:center; justify-content:center; gap:6px; transition:all 0.2s;">
                <i class="ti ti-x" style="font-size:14px;"></i> Cancelar
            </a>
            <button type="submit" 
                style="flex:2; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                <i class="ti ti-paw" style="font-size:14px;"></i> Registrar mascota
            </button>
        </div>
    </form>
</div>
</div>
@endsection