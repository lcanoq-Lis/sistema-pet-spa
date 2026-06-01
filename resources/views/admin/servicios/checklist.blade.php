@extends('layouts.dashboard')
@section('page-title', '✅ Checklist del Servicio')
@section('page-subtitle', 'Configura los ítems del checklist para {{ $servicio->nombre }}')

@section('content')
<div style="max-width:600px; margin:0 auto;">

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

{{-- Info del servicio --}}
<div class="card" style="margin-bottom:20px; background:linear-gradient(135deg,#ff7043,#ff8f00); border:none;">
    <div style="display:flex; align-items:center; gap:14px;">
        <div style="background:rgba(255,255,255,0.2); border-radius:14px; padding:14px; font-size:28px;">✂️</div>
        <div>
            <p style="font-size:16px; font-weight:700; color:white; margin:0;">{{ $servicio->nombre }}</p>
            <p style="font-size:12px; color:rgba(255,255,255,0.8); margin:0;">{{ $servicio->descripcion }}</p>
            <p style="font-size:12px; color:rgba(255,255,255,0.8); margin:4px 0 0;">
                Bs. {{ $servicio->precio_base }} · {{ $servicio->duracion_base_minutos }} min
            </p>
        </div>
    </div>
</div>

{{-- Formulario checklist --}}
<div class="card">
    <div style="background:linear-gradient(135deg,#2e7d32,#43a047); margin:-22px -22px 20px; padding:16px 20px; border-radius:14px 14px 0 0; display:flex; align-items:center; gap:10px;">
        <span style="font-size:20px;">✅</span>
        <h3 style="font-size:14px; font-weight:700; color:white; margin:0;">
            Ítems del checklist — selecciona los que aplican a este servicio
        </h3>
    </div>

    <form method="POST" action="{{ route('admin.servicios.checklist.guardar', $servicio->id) }}">
        @csrf

        <p style="font-size:13px; color:#a1887f; margin-bottom:16px;">
            Marca los ítems que el groomer debe completar para este servicio. El orden en que los selecciones será el orden en la ficha.
        </p>

        <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:20px;">
            @foreach($todosItems as $i => $item)
            <label style="display:flex; align-items:center; gap:12px; padding:12px 14px; border:1.5px solid {{ in_array($item->id, $itemsActivos) ? '#43a047' : '#d7ccc8' }}; border-radius:10px; cursor:pointer; background:{{ in_array($item->id, $itemsActivos) ? '#f1f8e9' : 'white' }}; transition:all 0.2s;"
                onclick="this.style.borderColor=this.querySelector('input').checked?'#d7ccc8':'#43a047'; this.style.background=this.querySelector('input').checked?'white':'#f1f8e9';">
                <input type="checkbox" name="items[]" value="{{ $item->id }}"
                    {{ in_array($item->id, $itemsActivos) ? 'checked' : '' }}
                    style="width:18px; height:18px; accent-color:#43a047; flex-shrink:0;">
                <div style="flex:1;">
                    <p style="font-size:14px; font-weight:600; color:#5d4037; margin:0;">{{ $item->nombre }}</p>
                    @if($item->requiere_observacion)
                        <p style="font-size:11px; color:#a1887f; margin:2px 0 0;">📝 Requiere observación</p>
                    @endif
                </div>
                @if(in_array($item->id, $itemsActivos))
                    <span style="font-size:11px; background:#e8f5e9; color:#2e7d32; padding:2px 8px; border-radius:10px; font-weight:600;">✓ Activo</span>
                @endif
            </label>
            @endforeach
        </div>

        <div style="display:flex; gap:10px;">
            <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary" style="flex:1; text-align:center;">
                ← Volver
            </a>
            <button type="submit" class="btn btn-primary" style="flex:2;">
                💾 Guardar checklist
            </button>
        </div>
    </form>
</div>

</div>
@endsection
