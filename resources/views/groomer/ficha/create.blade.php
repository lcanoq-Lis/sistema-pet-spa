@extends('layouts.dashboard')

@section('page-title', '📋 Nueva Ficha')
@section('page-subtitle', 'Registra el estado inicial de la mascota')

@section('content')
<div style="max-width:700px; margin:0 auto;">
    <div class="stat-card">

        {{-- Info de la cita --}}
        <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); border-radius:12px; padding:16px; margin-bottom:24px; color:white;">
            <div style="display:flex; gap:16px; align-items:center;">
                <div style="font-size:48px;">
                    @if($cita->mascota->especie === 'perro') 🐶
                    @elseif($cita->mascota->especie === 'gato') 🐱
                    @else 🐾
                    @endif
                </div>
                <div>
                    <h3 style="font-size:18px; font-weight:800;">{{ $cita->mascota->nombre }}</h3>
                    <p style="opacity:0.9; font-size:13px;">{{ $cita->servicio->nombre }}</p>
                    <p style="opacity:0.8; font-size:12px;">🕐 {{ $cita->fecha_hora_inicio->format('H:i') }}</p>
                    @if($cita->mascota->alergias)
                    <p style="background:rgba(0,0,0,0.2); border-radius:6px; padding:4px 8px; font-size:12px; margin-top:4px;">
                        ⚠️ Alergias: {{ $cita->mascota->alergias }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        @if($errors->any())
            <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('groomer.ficha.store') }}">
            @csrf
            <input type="hidden" name="cita_id" value="{{ $cita->id }}">

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Temperatura corporal (°C)</label>
                    <input type="number" name="temperatura_ingreso" step="0.1" min="35" max="42"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        placeholder="Ej: 38.5">
                </div>
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Estado inicial de la mascota *</label>
                <textarea name="estado_inicial" rows="4" required
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                    placeholder="Describe el estado de la mascota al ingreso: nudos, heridas, pulgas, comportamiento..."></textarea>
            </div>

            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Notas internas</label>
                <textarea name="notas_internas" rows="3"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                    placeholder="Notas solo para el equipo..."></textarea>
            </div>

            {{-- Checklist preview --}}
            @if($items->isNotEmpty())
            <div style="background:#f5f0eb; border-radius:12px; padding:16px; margin-bottom:24px;">
                <p style="font-size:13px; font-weight:600; color:#5d4037; margin-bottom:8px;">📋 Checklist del servicio:</p>
                @foreach($items as $item)
                <div style="display:flex; align-items:center; gap:8px; padding:6px 0; border-bottom:1px solid #ede0d4;">
                    <span style="font-size:16px;">⬜</span>
                    <span style="font-size:13px; color:#8d6e63;">{{ $item->nombre }}</span>
                </div>
                @endforeach
                <p style="font-size:12px; color:#a1887f; margin-top:8px;">Podrás marcar estos items al editar la ficha.</p>
            </div>
            @endif

            <div style="display:flex; gap:12px;">
                <a href="{{ route('groomer.agenda.index') }}"
                    style="flex:1; text-align:center; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
                    ← Volver
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Abrir Ficha y comenzar servicio 🐾
                </button>
            </div>
        </form>
    </div>
</div>
@endsection