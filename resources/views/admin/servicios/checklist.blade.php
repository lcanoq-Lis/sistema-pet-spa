@extends('layouts.dashboard')
@section('page-title', 'Checklist del Servicio')
@section('page-subtitle', 'Configura los ítems del checklist para {{ $servicio->nombre }}')

@section('content')
<div style="max-width:700px; margin:0 auto;">

@if(session('status'))
    <div style="background:#E8F5E9; color:#2E7D32; border-left:4px solid #43A047; padding:14px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="font-size:18px;"></i> {{ session('status') }}
    </div>
@endif

{{-- Info del servicio --}}
<div style="background:linear-gradient(135deg,#2E7D32,#43A047); border-radius:20px; margin-bottom:24px; padding:20px;">
    <div style="display:flex; align-items:center; gap:16px;">
        <div style="background:rgba(255,255,255,0.2); border-radius:16px; padding:14px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-scissors" style="font-size:28px; color:white;"></i>
        </div>
        <div>
            <p style="font-size:16px; font-weight:700; color:white; margin:0;">{{ $servicio->nombre }}</p>
            <p style="font-size:12px; color:rgba(255,255,255,0.85); margin:4px 0 0;">{{ $servicio->descripcion }}</p>
            <p style="font-size:11px; color:rgba(255,255,255,0.75); margin:6px 0 0;">
                <i class="ti ti-coin" style="font-size:11px;"></i> Bs. {{ $servicio->precio_base }} ·
                <i class="ti ti-clock" style="font-size:11px;"></i> {{ $servicio->duracion_base_minutos }} min
            </p>
        </div>
    </div>
</div>

{{-- Formulario checklist --}}
<div class="stat-card" style="border-radius:24px; padding:28px;">
    <div style="margin-bottom:24px;">
        <h3 style="font-size:14px; font-weight:700; color:#2E7D32; margin:0; display:flex; align-items:center; gap:10px;">
            <i class="ti ti-checklist" style="font-size:18px;"></i>
            Ítems del checklist — selecciona los que aplican a este servicio
        </h3>
    </div>

    <form method="POST" action="{{ route('admin.servicios.checklist.guardar', $servicio->id) }}">
        @csrf

        <p style="font-size:12px; color:#A1887F; margin-bottom:20px; display:flex; align-items:center; gap:6px;">
            <i class="ti ti-info-circle" style="font-size:14px;"></i>
            Marca los ítems que el groomer debe completar para este servicio. El orden en que los selecciones será el orden en la ficha.
        </p>

        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:28px;">
            @foreach($todosItems as $i => $item)
            @php $isActive = in_array($item->id, $itemsActivos); @endphp
            <label style="display:flex; align-items:center; gap:14px; padding:14px 16px; border:2px solid {{ $isActive ? '#4CAF50' : '#E0D6CC' }}; border-radius:16px; cursor:pointer; background:{{ $isActive ? '#F1F8E9' : 'white' }}; transition:all 0.2s;">
                <input type="checkbox" name="items[]" value="{{ $item->id }}"
                    {{ $isActive ? 'checked' : '' }}
                    style="width:18px; height:18px; accent-color:#4CAF50; flex-shrink:0;">
                <div style="flex:1;">
                    <p style="font-size:14px; font-weight:600; color:#5D4037; margin:0;">{{ $item->nombre }}</p>
                    @if($item->requiere_observacion)
                        <p style="font-size:11px; color:#A1887F; margin:4px 0 0; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-notes" style="font-size:11px;"></i> Requiere observación
                        </p>
                    @endif
                </div>
                @if($isActive)
                    <span style="background:#E8F5E9; color:#2E7D32; padding:4px 12px; border-radius:40px; font-size:10px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                        <i class="ti ti-check" style="font-size:10px;"></i> Activo
                    </span>
                @endif
            </label>
            @endforeach
        </div>

        <div style="display:flex; gap:14px;">
            <a href="{{ route('admin.servicios.index') }}"
                style="flex:1; text-align:center; background:#F5F0EB; color:#8D6E63; font-weight:600; padding:14px; border-radius:40px; text-decoration:none; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                <i class="ti ti-arrow-left"></i> Volver
            </a>
            <button type="submit"
                style="flex:2; background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:700; padding:14px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                <i class="ti ti-device-floppy"></i> Guardar checklist
            </button>
        </div>
    </form>
</div>

</div>
@endsection