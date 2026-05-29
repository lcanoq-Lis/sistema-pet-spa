@extends('layouts.app')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-logo">
            <div class="auth-logo-icon">🐾</div>
            <h1>Crear cuenta</h1>
            <p>Regístrate para gestionar las citas de tu mascota</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="margin:0; padding-left:16px; font-size:13px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <div class="field">
                <label class="field-label">Nombre completo</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    class="field-input" placeholder="Tu nombre completo" required>
            </div>

            <div class="field">
                <label class="field-label">Correo electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    class="field-input" placeholder="tu@correo.com" required>
            </div>

            <div class="field">
                <label class="field-label">Teléfono <span style="color:#6B8F6B; font-weight:400;">(opcional)</span></label>
                <input type="text" name="telefono" value="{{ old('telefono') }}"
                    class="field-input" placeholder="+591 7xxxxxxx">
            </div>

            <div class="field">
                <label class="field-label">Contraseña</label>
                <input type="password" name="password" id="password"
                    class="field-input" placeholder="Mínimo 8 caracteres" required
                    oninput="checkStrength(this.value)">
                <div class="strength-bar">
                    <div class="strength-bar-segment" id="s1"></div>
                    <div class="strength-bar-segment" id="s2"></div>
                    <div class="strength-bar-segment" id="s3"></div>
                    <div class="strength-bar-segment" id="s4"></div>
                </div>
                <p class="strength-text" id="strength-text">Debe incluir mayúsculas, minúsculas, números y símbolos</p>
            </div>

            <div class="field" style="margin-bottom:24px;">
                <label class="field-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation"
                    class="field-input" placeholder="Repite tu contraseña" required>
            </div>

            <button type="submit" class="btn-auth">Crear cuenta →</button>
        </form>

        <p class="auth-footer">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}">Inicia sesión</a>
        </p>
    </div>
</div>

<script>
function checkStrength(pwd) {
    const segs = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    const txt  = document.getElementById('strength-text');
    let score  = 0;
    if (pwd.length >= 8)        score++;
    if (/[A-Z]/.test(pwd))      score++;
    if (/[0-9]/.test(pwd))      score++;
    if (/[@$!%*#?&]/.test(pwd)) score++;
    const colors = ['#EF5350','#FF9800','#FFC107','#2E7D32'];
    const labels = ['Muy débil','Débil','Aceptable','Fuerte ✓'];
    segs.forEach((s,i) => s.style.background = i < score ? colors[score-1] : '#DDE8DD');
    txt.textContent = pwd.length === 0 ? 'Debe incluir mayúsculas, minúsculas, números y símbolos' : (labels[score-1] || 'Muy débil');
    txt.style.color = pwd.length === 0 ? '#6B8F6B' : colors[score-1] || '#EF5350';
}
</script>
@endsection