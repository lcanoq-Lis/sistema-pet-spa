@extends('layouts.dashboard')
@section('page-title', '👤 Registrar Cliente')
@section('page-subtitle', 'Crear nuevo cliente desde recepción')

@section('content')
<div style="max-width:560px; margin:0 auto;">

@if($errors->any())
    <div class="alert alert-error">❌ {{ $errors->first() }}</div>
@endif

<div class="card">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); margin:-22px -22px 20px; padding:16px 20px; border-radius:14px 14px 0 0; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">👤</span>
        <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">Datos del cliente</h3>
    </div>

    <form method="POST" action="{{ route('recepcion.clientes.store') }}">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
            <div>
                <label class="form-label">Nombre completo *</label>
                <input type="text" name="name" class="form-input" required value="{{ old('name') }}" placeholder="Juan Pérez">
            </div>
            <div>
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-input" value="{{ old('apellido') }}" placeholder="Opcional">
            </div>
        </div>

        <div style="margin-bottom:14px;">
            <label class="form-label">Correo electrónico *</label>
            <input type="email" name="email" class="form-input" required value="{{ old('email') }}" placeholder="cliente@email.com">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
    <div>
        <label class="form-label">Contraseña *</label>
        <input type="password" name="password" class="form-input" required placeholder="Mín. 8 car. con mayús, núm y símbolo">
        <div id="password-strength" style="margin-top:8px;">
    <div style="display:flex; gap:4px; margin-bottom:4px;">
        <div id="bar1" style="height:4px; flex:1; border-radius:2px; background:#d7ccc8;"></div>
        <div id="bar2" style="height:4px; flex:1; border-radius:2px; background:#d7ccc8;"></div>
        <div id="bar3" style="height:4px; flex:1; border-radius:2px; background:#d7ccc8;"></div>
        <div id="bar4" style="height:4px; flex:1; border-radius:2px; background:#d7ccc8;"></div>
    </div>
    <p id="strength-text" style="font-size:11px; color:#a1887f; margin:0;"></p>
</div>

<script>
document.querySelector('input[name="password"]').addEventListener('input', function() {
    const val = this.value;
    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))          score++;
    if (/[0-9]/.test(val))          score++;
    if (/[@$!%*#?&]/.test(val))     score++;

    const colors = ['#ef5350','#ff7043','#ffa726','#66bb6a'];
    const labels = ['Muy débil','Débil','Regular','Segura'];
    const bars   = ['bar1','bar2','bar3','bar4'];

    bars.forEach((id, i) => {
        document.getElementById(id).style.background = i < score ? colors[score-1] : '#d7ccc8';
    });
    document.getElementById('strength-text').textContent = val.length > 0 ? labels[score-1] ?? '' : '';
    document.getElementById('strength-text').style.color = score > 0 ? colors[score-1] : '#a1887f';
});
</script>
    </div>

    <div>
        <label class="form-label">Confirmar contraseña *</label>
        <input type="password" name="password_confirmation" class="form-input" required placeholder="Repite la contraseña">
    </div>
</div>

<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:14px;">
    <div>
        <label class="form-label">CI</label>
        <input type="text" name="ci" class="form-input" value="{{ old('ci') }}" placeholder="12345678">
    </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:14px; margin-bottom:20px;">
            <div>
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-input" value="{{ old('telefono') }}" placeholder="60000000">
            </div>
            <div>
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-input" value="{{ old('direccion') }}" placeholder="Zona, calle...">
            </div>
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('recepcion.clientes.index') }}" class="btn btn-secondary" style="flex:1; text-align:center;">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary" style="flex:2;">
                ✅ Registrar cliente
            </button>
        </div>
    </form>
</div>
</div>
@endsection
