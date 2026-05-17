@extends('layouts.dashboard')

@section('page-title', '🔐 Cambiar Contraseña')
@section('page-subtitle', 'Actualiza tu contraseña de acceso')

@section('content')
<div style="max-width:500px; margin:0 auto;">
    <div class="stat-card">

        @if($errors->any())
            <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.cambiar.post') }}">
            @csrf

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Contraseña actual *</label>
                <input type="password" name="password_actual"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                    required>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nueva contraseña *</label>
                <input type="password" name="password_nuevo"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                    required>
                <p style="font-size:12px; color:#a1887f; margin-top:4px;">Mínimo 8 caracteres con mayúsculas, minúsculas, números y símbolos.</p>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Confirmar nueva contraseña *</label>
                <input type="password" name="password_nuevo_confirmation"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                    required>
            </div>

            <button type="submit"
                style="width:100%; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                Actualizar contraseña 🔐
            </button>
        </form>
    </div>
</div>
@endsection