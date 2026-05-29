@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-logo">
            <div class="auth-logo-icon">🐾</div>
            <h1>Pet Spa</h1>
            <p>Bienvenido de vuelta</p>
        </div>

        @if(session('status'))
            <div class="alert alert-success">✅ {{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">⚠️ {{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="field">
                <label class="field-label">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="field-input" placeholder="tu@correo.com" required>
            </div>

            <div class="field">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:6px;">
                    <label class="field-label" style="margin:0;">Contraseña</label>
                    <a href="{{ route('password.recuperar') }}" class="link-muted">¿Olvidaste tu contraseña?</a>
                </div>
                <input type="password" name="password"
                    class="field-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-auth">Iniciar sesión →</button>
        </form>

        <div class="auth-divider"><span>o continúa con</span></div>

        <a href="{{ route('google.redirect') }}" class="btn-google">
            <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="18" height="18" alt="Google">
            Continuar con Google
        </a>

        <p class="auth-footer">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}">Regístrate aquí</a>
        </p>
    </div>
</div>
@endsection