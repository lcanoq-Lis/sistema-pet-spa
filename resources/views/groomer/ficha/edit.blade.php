@extends('layouts.dashboard')

@section('page-title', '📋 Ficha de Grooming')
@section('page-subtitle', 'Completa el checklist y cierra la ficha')

@section('content')
<div style="max-width:700px; margin:0 auto;">

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ⚠️ {{ $errors->first() }}
    </div>
@endif

    {{-- Info mascota --}}
    <div class="stat-card" style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; margin-bottom:16px;">
        <div style="display:flex; gap:16px; align-items:center;">
            <div style="font-size:48px;">
                @if($ficha->cita->mascota->especie === 'perro') 🐶
                @elseif($ficha->cita->mascota->especie === 'gato') 🐱
                @else 🐾
                @endif
            </div>
            <div>
                <h3 style="font-size:18px; font-weight:800;">{{ $ficha->cita->mascota->nombre }}</h3>
                <p style="opacity:0.9;">{{ $ficha->cita->servicio->nombre }}</p>
                <p style="opacity:0.8; font-size:13px;">Estado ingreso: {{ $ficha->estado_inicial }}</p>
            </div>
        </div>
    </div>

    {{-- Checklist --}}
<form method="POST" action="{{ route('groomer.ficha.update', $ficha->id) }}">
    @csrf
    <div class="stat-card" style="margin-bottom:16px;">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">✅ Checklist del servicio</h3>

        @foreach($ficha->checklist as $check)
        <div style="display:flex; align-items:start; gap:12px; padding:12px 0; border-bottom:1px solid #f5f0eb; cursor:pointer;"
             onclick="toggleCheck({{ $check->item_id }})">
            
            <div id="box-{{ $check->item_id }}"
                style="width:22px; height:22px; border-radius:6px; border:2px solid #d7ccc8; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:2px; transition:all 0.2s;
                {{ $check->completado ? 'background:linear-gradient(135deg,#ff7043,#ff8f00); border-color:#ff7043;' : '' }}">
                @if($check->completado)
                <span style="color:white; font-size:14px;">✓</span>
                @endif
            </div>

            <input type="checkbox" 
                name="checklist[{{ $check->item_id }}][completado]"
                id="check-{{ $check->item_id }}"
                {{ $check->completado ? 'checked' : '' }}
                style="display:none;">

            <div style="flex:1;">
                <label style="font-size:14px; font-weight:600; color:#5d4037; cursor:pointer;
                    {{ $check->completado ? 'text-decoration:line-through; color:#a1887f;' : '' }}"
                    id="label-{{ $check->item_id }}">
                    {{ $check->item->nombre }}
                </label>
                @if($check->item->requiere_observacion)
                <input type="text" name="checklist[{{ $check->item_id }}][observacion]"
                    value="{{ $check->observacion }}"
                    placeholder="Observación requerida..."
                    onclick="event.stopPropagation()"
                    style="width:100%; border:1px solid #d7ccc8; border-radius:8px; padding:6px 10px; font-size:13px; outline:none; font-family:Poppins,sans-serif; margin-top:6px;">
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="stat-card" style="margin-bottom:16px;">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:12px;">📝 Estado final</h3>
        <textarea name="estado_final" rows="3"
            style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
            placeholder="Describe el estado final de la mascota...">{{ $ficha->estado_final }}</textarea>

        <div style="margin-top:12px;">
            <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Notas internas</label>
            <textarea name="notas_internas" rows="2"
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                placeholder="Notas solo para el equipo...">{{ $ficha->notas_internas }}</textarea>
        </div>
    </div>

    <button type="submit"
        style="width:100%; background:linear-gradient(135deg,#1565c0,#1976d2); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif; margin-bottom:12px;">
        💾 Guardar cambios
    </button>
</form>
    {{-- Cerrar ficha --}}
    @if(!$ficha->fecha_cierre)
    <form method="POST" action="{{ route('groomer.ficha.cerrar', $ficha->id) }}">
        @csrf
        <button type="submit"
            onclick="return confirm('¿Cerrar la ficha? El cliente será notificado que puede recoger a su mascota.')"
            style="width:100%; background:linear-gradient(135deg,#2e7d32,#43a047); color:white; font-weight:700; padding:14px; border-radius:10px; border:none; cursor:pointer; font-size:15px; font-family:Poppins,sans-serif;">
            🎉 Cerrar ficha y notificar al cliente
        </button>
    </form>
    @else
    <div style="background:#e8f5e9; color:#2e7d32; border-radius:10px; padding:14px; text-align:center; font-weight:600;">
        ✅ Ficha cerrada el {{ $ficha->fecha_cierre->format('d/m/Y H:i') }}
    </div>
    @endif

</div>
<script>
function toggleCheck(itemId) {
    const checkbox = document.getElementById('check-' + itemId);
    const box      = document.getElementById('box-' + itemId);
    const label    = document.getElementById('label-' + itemId);

    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        box.style.background = 'linear-gradient(135deg,#ff7043,#ff8f00)';
        box.style.borderColor = '#ff7043';
        box.innerHTML = '<span style="color:white; font-size:14px;">✓</span>';
        label.style.textDecoration = 'line-through';
        label.style.color = '#a1887f';
    } else {
        box.style.background = 'white';
        box.style.borderColor = '#d7ccc8';
        box.innerHTML = '';
        label.style.textDecoration = 'none';
        label.style.color = '#5d4037';
    }
}
</script>
@endsection