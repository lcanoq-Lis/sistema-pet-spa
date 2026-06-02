@extends('layouts.dashboard')

@section('page-title', 'Agregar Personal')
@section('page-subtitle', 'Se enviará un email con las credenciales')

@section('content')
<div style="max-width:600px; margin:0 auto;">
    <div style="background:#fff; border-radius:24px; border:0.5px solid #e0e0e0; padding:32px; box-shadow:0 4px 12px rgba(0,0,0,0.03);">

        @if($errors->any())
            <div style="background:#FFF8E1; border-left:4px solid #FF7043; border-radius:12px; padding:14px 18px; margin-bottom:24px;">
                <ul style="margin:0; padding-left:20px; color:#E65100; font-size:13px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.personal.store') }}">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-user" style="font-size:12px;"></i> Nombre completo *
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    placeholder="Ej: Juan Pérez"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-mail" style="font-size:12px;"></i> Correo electrónico *
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    placeholder="correo@ejemplo.com"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-shield" style="font-size:12px;"></i> Rol *
                </label>
                <select name="rol" required
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                    <option value="">Selecciona un rol</option>
                    <option value="groomer" {{ old('rol') === 'groomer' ? 'selected' : '' }}>Groomer</option>
                    <option value="recepcion" {{ old('rol') === 'recepcion' ? 'selected' : '' }}>Recepción</option>
                </select>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-phone" style="font-size:12px;"></i> Teléfono
                    <span style="color:#8A9B8A; font-weight:400;">(opcional)</span>
                </label>
                <input type="text" name="telefono" value="{{ old('telefono') }}"
                    placeholder="+591 7xxxxxxx"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-scissors" style="font-size:12px;"></i> Especialidad
                    <span style="color:#8A9B8A; font-weight:400;">(solo Groomers)</span>
                </label>
                <input type="text" name="especialidad" value="{{ old('especialidad') }}"
                    placeholder="Ej: Corte fino, razas pequeñas..."
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>

            <div style="display:flex; gap:14px;">
                <a href="{{ route('admin.personal.index') }}"
                    style="flex:1; text-align:center; background:#fff; border:1.5px solid #e0e0e0; border-radius:40px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; justify-content:center; gap:6px; transition:all 0.2s;">
                    <i class="ti ti-arrow-left" style="font-size:14px;"></i> Volver
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:40px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-mail" style="font-size:14px;"></i> Crear cuenta y enviar credenciales
                </button>
            </div>
        </form>
    </div>
</div>
@endsection