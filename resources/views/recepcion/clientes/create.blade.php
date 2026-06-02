@extends('layouts.dashboard')
@section('page-title', 'Registrar Cliente')
@section('page-subtitle', 'Crear nuevo cliente desde recepción')

@section('content')
<div style="max-width:600px; margin:0 auto;">

@if($errors->any())
    <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
        <p style="color:#C62828; font-size:13px; font-weight:500; margin:0;">{{ $errors->first() }}</p>
    </div>
@endif

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); padding:16px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-user-plus" style="font-size:20px; color:#fff;"></i>
        </div>
        <h3 style="font-size:14px; font-weight:700; color:#fff; margin:0;">Datos del cliente</h3>
    </div>

    <form method="POST" action="{{ route('recepcion.clientes.store') }}" style="padding:24px;">
        @csrf

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-user" style="font-size:12px;"></i> Nombre completo *
                </label>
                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Juan Pérez"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-id" style="font-size:12px;"></i> Apellido
                </label>
                <input type="text" name="apellido" value="{{ old('apellido') }}" placeholder="Opcional"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="margin-bottom:20px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-mail" style="font-size:12px;"></i> Correo electrónico *
            </label>
            <input type="email" name="email" required value="{{ old('email') }}" placeholder="cliente@email.com"
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-lock" style="font-size:12px;"></i> Contraseña *
                </label>
                <input type="password" name="password" id="password-input" required placeholder="Mín. 8 car. con mayús, núm y símbolo"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
                
                <div id="password-strength" style="margin-top:10px;">
                    <div style="display:flex; gap:6px; margin-bottom:6px;">
                        <div id="bar1" style="height:4px; flex:1; border-radius:4px; background:#E0E0E0;"></div>
                        <div id="bar2" style="height:4px; flex:1; border-radius:4px; background:#E0E0E0;"></div>
                        <div id="bar3" style="height:4px; flex:1; border-radius:4px; background:#E0E0E0;"></div>
                        <div id="bar4" style="height:4px; flex:1; border-radius:4px; background:#E0E0E0;"></div>
                    </div>
                    <p id="strength-text" style="font-size:11px; color:#8A9B8A; margin:0;"></p>
                </div>
            </div>

            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-lock-check" style="font-size:12px;"></i> Confirmar contraseña *
                </label>
                <input type="password" name="password_confirmation" required placeholder="Repite la contraseña"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:20px;">
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-id-badge" style="font-size:12px;"></i> CI
                </label>
                <input type="text" name="ci" value="{{ old('ci') }}" placeholder="12345678"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
            <div>
                <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                    <i class="ti ti-phone" style="font-size:12px;"></i> Teléfono
                </label>
                <input type="text" name="telefono" value="{{ old('telefono') }}" placeholder="60000000"
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>
        </div>

        <div style="margin-bottom:24px;">
            <label style="display:block; font-size:12px; font-weight:700; color:#4A7A4A; margin-bottom:8px;">
                <i class="ti ti-map-pin" style="font-size:12px;"></i> Dirección
            </label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" placeholder="Zona, calle..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s; box-sizing:border-box;"
                onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <div style="display:flex; gap:14px;">
            <a href="{{ route('recepcion.clientes.index') }}" 
                style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; text-decoration:none; text-align:center; display:inline-flex; align-items:center; justify-content:center; gap:6px; transition:all 0.2s;">
                <i class="ti ti-x" style="font-size:14px;"></i> Cancelar
            </a>
            <button type="submit" 
                style="flex:2; background:linear-gradient(135deg, #1B5E20, #0D3B0D); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:8px;">
                <i class="ti ti-check" style="font-size:14px;"></i> Registrar cliente
            </button>
        </div>
    </form>
</div>
</div>

<script>
document.querySelector('input[name="password"]').addEventListener('input', function() {
    const val = this.value;
    let score = 0;
    if (val.length >= 8)            score++;
    if (/[A-Z]/.test(val))          score++;
    if (/[0-9]/.test(val))          score++;
    if (/[@$!%*#?&]/.test(val))     score++;

    const colors = ['#EF5350','#FF7043','#FFA726','#66BB6A'];
    const labels = ['Muy débil','Débil','Regular','Segura'];
    const bars   = ['bar1','bar2','bar3','bar4'];

    bars.forEach((id, i) => {
        document.getElementById(id).style.background = i < score ? colors[score-1] : '#E0E0E0';
    });
    document.getElementById('strength-text').textContent = val.length > 0 ? labels[score-1] ?? '' : '';
    document.getElementById('strength-text').style.color = score > 0 ? colors[score-1] : '#8A9B8A';
});
</script>
@endsection
