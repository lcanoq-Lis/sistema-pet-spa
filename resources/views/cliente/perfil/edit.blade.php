@extends('layouts.dashboard')
@section('page-title', 'Mi Perfil')
@section('page-subtitle', 'Edita tu información personal')

@section('content')
<div style="max-width:600px; margin:0 auto;">

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

@if($errors->any())
    <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
        <p style="color:#C62828; font-size:13px; font-weight:500; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif

{{-- Info personal --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; margin-bottom:24px; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #FF7043, #F57F17); padding:20px 24px; display:flex; align-items:center; gap:16px;">
        <div style="width:56px; height:56px; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
            <span style="font-size:24px; font-weight:800; color:#fff;">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
        </div>
        <div>
            <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0;">{{ $usuario->name }}</h3>
            <p style="font-size:12px; color:rgba(255,255,255,0.85); margin:4px 0 0; display:flex; align-items:center; gap:5px;">
                <i class="ti ti-mail" style="font-size:12px;"></i> {{ $usuario->email }}
            </p>
        </div>
    </div>

    <form method="POST" action="{{ route('cliente.perfil.update') }}" style="padding:24px;">
        @csrf @method('PUT')

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-user" style="font-size:12px;"></i> Nombre completo *
                </label>
                <input type="text" name="name" required value="{{ old('name', $usuario->name) }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-id" style="font-size:12px;"></i> Apellido
                </label>
                <input type="text" name="apellido" value="{{ old('apellido', $cliente?->apellido) }}"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-phone" style="font-size:12px;"></i> Teléfono
                </label>
                <input type="text" name="telefono" value="{{ old('telefono', $cliente?->telefono) }}" placeholder="60000000"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-id-badge" style="font-size:12px;"></i> CI
                </label>
                <input type="text" name="ci" value="{{ old('ci', $usuario->ci) }}" placeholder="12345678"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-map-pin" style="font-size:12px;"></i> Dirección
            </label>
            <input type="text" name="direccion" value="{{ old('direccion', $cliente?->direccion) }}" placeholder="Zona, calle, número..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <button type="submit" 
            style="width:100%; background:linear-gradient(135deg, #FF7043, #F57F17); border:none; border-radius:14px; padding:14px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
            <i class="ti ti-device-floppy" style="font-size:16px;"></i> Guardar cambios
        </button>
    </form>
</div>

{{-- Cambiar contraseña --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1565C0, #0D3B5E); padding:18px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-lock" style="font-size:18px; color:#fff;"></i>
        </div>
        <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Cambiar contraseña</h3>
    </div>

    <form method="POST" action="{{ route('cliente.perfil.password') }}" style="padding:24px;">
        @csrf

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-key" style="font-size:12px;"></i> Contraseña actual *
            </label>
            <input type="password" name="password_actual" required placeholder="Tu contraseña actual"
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                onfocus="this.style.borderColor='#1565C0'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            @error('password_actual')
                <p style="color:#C62828; font-size:11px; margin-top:6px; display:flex; align-items:center; gap:4px;">
                    <i class="ti ti-alert-circle" style="font-size:12px;"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:24px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-lock" style="font-size:12px;"></i> Nueva contraseña *
                </label>
                <input type="password" name="password" required placeholder="Mín. 8 caracteres"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#1565C0'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-lock-check" style="font-size:12px;"></i> Confirmar contraseña *
                </label>
                <input type="password" name="password_confirmation" required placeholder="Repite la contraseña"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#1565C0'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <button type="submit" 
            style="width:100%; background:linear-gradient(135deg, #1565C0, #0D3B5E); border:none; border-radius:14px; padding:14px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
            <i class="ti ti-lock" style="font-size:16px;"></i> Actualizar contraseña
        </button>
    </form>
</div>


</div>
@endsection