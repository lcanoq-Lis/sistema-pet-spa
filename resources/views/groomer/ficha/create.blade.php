@extends('layouts.dashboard')

@section('page-title', 'Nueva Ficha')
@section('page-subtitle', 'Registra el estado inicial de la mascota')

@section('content')
<div style="max-width: 720px; margin: 0 auto;">
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:28px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">

        {{-- Info de la cita --}}
        <div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); border-radius:16px; padding:24px; margin-bottom:24px; color:#fff; position:relative; overflow:hidden;">
            <div style="position:absolute; right:-20px; top:-30px; width:140px; height:140px; border-radius:50%; background:rgba(255,255,255,0.05);"></div>
            <div style="position:absolute; right:30px; bottom:-40px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
            <div style="display:flex; gap:18px; align-items:center; position:relative;">
                <div style="width:56px; height:56px; background:rgba(255,255,255,0.12); border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:24px;">
                    <i class="ti ti-paw"></i>
                </div>
                <div style="flex:1;">
                    <h3 style="font-size:18px; font-weight:800; margin:0;">{{ $cita->mascota->nombre }}</h3>
                    <p style="opacity:0.9; font-size:12px; margin:2px 0 0;">{{ $cita->servicio->nombre }}</p>
                    <div style="display:flex; align-items:center; gap:8px; margin-top:8px; flex-wrap:wrap;">
                        <span style="opacity:0.8; font-size:11px; background:rgba(0,0,0,0.15); padding:4px 10px; border-radius:20px; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-clock" style="font-size:12px;"></i> {{ $cita->fecha_hora_inicio->format('H:i') }}
                        </span>
                    </div>
                    @if($cita->mascota->alergias)
                    <div style="background:rgba(239,68,68,0.2); border:1px solid rgba(239,68,68,0.3); border-radius:8px; padding:6px 12px; margin-top:10px; display:inline-flex; align-items:center; gap:6px;">
                        <i class="ti ti-alert-triangle" style="font-size:12px;"></i>
                        <span style="font-size:11px; font-weight:500;">Alergias: {{ $cita->mascota->alergias }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($errors->any())
            <div style="background:#FFEBEE; border-left:4px solid #C62828; border-radius:12px; padding:14px 18px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
                <i class="ti ti-alert-circle" style="color:#C62828; font-size:18px;"></i>
                <p style="color:#C62828; font-size:13px; font-weight:600; margin:0;">{{ $errors->first() }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('groomer.ficha.store') }}">
            @csrf
            <input type="hidden" name="cita_id" value="{{ $cita->id }}">

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                    <i class="ti ti-temperature" style="font-size:12px;"></i> Temperatura corporal (°C)
                </label>
                <input type="number" name="temperatura_ingreso" step="0.1" min="35" max="42"
                    style="width:100%; background:#FAFBF7; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:14px; outline:none; transition:all 0.2s;"
                    placeholder="Ej: 38.5"
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" 
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                    <i class="ti ti-notes"></i> Estado inicial de la mascota *
                </label>
                <textarea name="estado_inicial" rows="4" required
                    style="width:100%; background:#FAFBF7; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:14px; outline:none; resize:vertical; transition:all 0.2s; font-family:inherit;"
                    placeholder="Describe el estado de la mascota al ingreso: nudos, heridas, pulgas, comportamiento..."
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" 
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"></textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:11px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">
                    <i class="ti ti-lock"></i> Notas internas
                </label>
                <textarea name="notas_internas" rows="3"
                    style="width:100%; background:#FAFBF7; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px 14px; font-size:14px; outline:none; resize:vertical; transition:all 0.2s; font-family:inherit;"
                    placeholder="Notas confidenciales solo visibles para el equipo..."
                    onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" 
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"></textarea>
            </div>

            {{-- Checklist preview --}}
            @if($items->isNotEmpty())
            <div style="background:#F5F7F2; border-radius:16px; padding:20px; margin-bottom:28px; border:1px solid #E0E5D9;">
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                    <i class="ti ti-checklist" style="color:#4A7A4A; font-size:18px;"></i>
                    <p style="font-size:13px; font-weight:700; color:#1A2E1A; margin:0;">Checklist del servicio asignado</p>
                </div>
                <div style="display:flex; flex-direction:column; gap:12px;">
                    @foreach($items as $item)
                    <div style="display:flex; align-items:center; gap:12px; padding:6px 0;">
                        <div style="width:18px; height:18px; border:2px solid #BDBDBD; border-radius:6px; background:#fff;"></div>
                        <span style="font-size:13px; color:#4A5B4A;">{{ $item->nombre }}</span>
                    </div>
                    @endforeach
                </div>
                <div style="display:flex; align-items:center; gap:6px; margin-top:16px; padding-top:12px; border-top:1px solid #E0E5D9;">
                    <i class="ti ti-info-circle" style="font-size:12px; color:#8A9B8A;"></i>
                    <p style="font-size:11px; color:#8A9B8A; margin:0;">Podrás marcar estos ítems como completados una vez abras la ficha del servicio</p>
                </div>
            </div>
            @endif

            <div style="display:flex; gap:14px; align-items:center;">
                <a href="{{ route('groomer.agenda.index') }}" style="flex:1; text-align:center; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-size:13px; font-weight:600; color:#5D6E5D; text-decoration:none; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-arrow-left" style="font-size:14px;"></i> Volver a Agenda
                </a>
                <button type="submit" style="flex:2; background:#1B5E20; border:none; border-radius:14px; padding:12px; font-size:13px; font-weight:700; color:#fff; cursor:pointer; transition:all 0.2s; display:flex; align-items:center; justify-content:center; gap:8px;">
                    <i class="ti ti-file-description"></i> Abrir Ficha y comenzar servicio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection