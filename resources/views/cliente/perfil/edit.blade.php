@extends('layouts.dashboard')
@section('page-title', '👤 Mi Perfil')
@section('page-subtitle', 'Edita tu información personal')

@section('content')
<div style="max-width:600px; margin:0 auto;">

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-error">❌ {{ $errors->first() }}</div>
@endif

{{-- Info personal --}}
<div class="card" style="margin-bottom:20px;">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); margin:-22px -22px 20px; padding:16px 20px; border-radius:14px 14px 0 0; display:flex; align-items:center; gap:12px;">
        <div style="background:rgba(255,255,255,0.2); border-radius:50%; width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:22px; font-weight:700; color:white; flex-shrink:0;">
            {{ strtoupper(substr($usuario->name, 0, 1)) }}
        </div>
        <div>
            <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">{{ $usuario->name }}</h3>
            <p style="font-size:12px; color:rgba(255,255,255,0.8); margin:0;">{{ $usuario->email }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('cliente.perfil.update') }}">
        @csrf @method('PUT')

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label class="form-label">Nombre completo *</label>
                <input type="text" name="name" class="form-input" required value="{{ old('name', $usuario->name) }}">
            </div>
            <div>
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-input" value="{{ old('apellido', $cliente?->apellido) }}">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-input" value="{{ old('telefono', $cliente?->telefono) }}" placeholder="60000000">
            </div>
            <div>
                <label class="form-label">CI</label>
                <input type="text" name="ci" class="form-input" value="{{ old('ci', $usuario->ci) }}" placeholder="12345678">
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-input" value="{{ old('direccion', $cliente?->direccion) }}" placeholder="Zona, calle, número...">
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%;">
            💾 Guardar cambios
        </button>
    </form>
</div>

{{-- Cambiar contraseña --}}
<div class="card">
    <div style="background:linear-gradient(135deg,#1565c0,#1976d2); margin:-22px -22px 20px; padding:16px 20px; border-radius:14px 14px 0 0; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">🔐</span>
        <h3 style="font-size:15px; font-weight:700; color:white; margin:0;">Cambiar contraseña</h3>
    </div>

    <form method="POST" action="{{ route('cliente.perfil.password') }}">
        @csrf

        <div style="margin-bottom:14px;">
            <label class="form-label">Contraseña actual *</label>
            <input type="password" name="password_actual" class="form-input" required placeholder="Tu contraseña actual">
            @error('password_actual')
                <p style="color:#c62828; font-size:12px; margin-top:4px;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">
            <div>
                <label class="form-label">Nueva contraseña *</label>
                <input type="password" name="password" class="form-input" required placeholder="Mín. 8 car.">
            </div>
            <div>
                <label class="form-label">Confirmar contraseña *</label>
                <input type="password" name="password_confirmation" class="form-input" required placeholder="Repite la contraseña">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width:100%; background:linear-gradient(135deg,#1565c0,#1976d2);">
            🔐 Actualizar contraseña
        </button>
    </form>
</div>

</div>
@endsection
