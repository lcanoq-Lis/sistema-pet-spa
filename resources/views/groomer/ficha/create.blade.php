@extends('layouts.dashboard')

@section('page-title', '📋 Nueva Ficha')
@section('page-subtitle', 'Registra el estado inicial de la mascota')

@section('content')
<div style="max-width: 700px; margin: 0 auto;">
    <div class="stat-card" style="padding: 28px;">

        {{-- Info de la cita --}}
        <div style="background: linear-gradient(135deg, var(--brand), #0f766e); border-radius: var(--radius-lg); padding: 20px; margin-bottom: 24px; color: white; box-shadow: var(--shadow-sm);">
            <div style="display: flex; gap: 18px; align-items: center;">
                <div style="font-size: 40px; width: 64px; height: 64px; background: rgba(255,255,255,0.15); display: grid; place-items: center; border-radius: var(--radius-md); backdrop-filter: blur(4px);">
                    @if($cita->mascota->especie === 'perro') 🐶
                    @elseif($cita->mascota->especie === 'gato') 🐱
                    @else 🐾
                    @endif
                </div>
                <div style="flex: 1;">
                    <h3 style="font-size: 18px; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; margin: 0;">{{ $cita->mascota->nombre }}</h3>
                    <p style="opacity: 0.9; font-size: 13px; margin: 2px 0 0; font-weight: 500;">{{ $cita->servicio->nombre }}</p>
                    <p style="opacity: 0.8; font-size: 12px; margin: 4px 0 0; display: inline-flex; align-items: center; gap: 4px; background: rgba(0,0,0,0.15); padding: 2px 8px; border-radius: 6px;">
                        🕐 {{ $cita->fecha_hora_inicio->format('H:i') }}
                    </p>
                    @if($cita->mascota->alergias)
                    <p style="background: rgba(239, 68, 68, 0.25); border: 1px solid rgba(239, 68, 68, 0.4); border-radius: 6px; padding: 4px 10px; font-size: 12px; margin-top: 8px; font-weight: 600; display: inline-block;">
                        ⚠️ Alergias: {{ $cita->mascota->alergias }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="margin-bottom: 20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('groomer.ficha.store') }}">
            @csrf
            <input type="hidden" name="cita_id" value="{{ $cita->id }}">

            <div style="display: grid; grid-template-columns: 1fr; gap: 16px; margin-bottom: 20px;">
                <div style="max-width: 280px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Temperatura corporal (°C)</label>
                    <div style="position: relative;">
                        <input type="number" name="temperatura_ingreso" step="0.1" min="35" max="42"
                            style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 10px 14px; font-size: 14px; outline: none; font-family: 'DM Sans', sans-serif; transition: border-color 0.2s;"
                            placeholder="Ej: 38.5"
                            onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'">
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Estado inicial de la mascota *</label>
                <textarea name="estado_inicial" rows="4" required
                    style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 12px 14px; font-size: 14px; outline: none; font-family: 'DM Sans', sans-serif; resize: vertical; transition: border-color 0.2s;"
                    placeholder="Describe el estado de la mascota al ingreso: nudos, heridas, pulgas, comportamiento..."
                    onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'"></textarea>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--text-primary); margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Notas internas</label>
                <textarea name="notas_internas" rows="3"
                    style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 12px 14px; font-size: 14px; outline: none; font-family: 'DM Sans', sans-serif; resize: vertical; transition: border-color 0.2s;"
                    placeholder="Notas confidenciales solo visibles para el equipo..."
                    onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'"></textarea>
            </div>

            {{-- Checklist preview --}}
            @if($items->isNotEmpty())
            <div style="background: var(--bg); border-radius: var(--radius-lg); padding: 20px; margin-bottom: 28px; border: 1px solid var(--border);">
                <p style="font-size: 14px; font-weight: 700; color: var(--text-primary); margin-bottom: 12px; font-family: 'Plus Jakarta Sans', sans-serif; display: flex; align-items: center; gap: 8px;">
                    📋 Checklist del servicio asignado:
                </p>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    @foreach($items as $item)
                    <div style="display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px id=dashed var(--border);">
                        <span style="width: 18px; height: 18px; border: 2px solid var(--border); border-radius: 4px; display: inline-block; background: #fff;"></span>
                        <span style="font-size: 13px; color: var(--text-secondary); font-weight: 500;">{{ $item->nombre }}</span>
                    </div>
                    @endforeach
                </div>
                <p style="font-size: 12px; color: var(--text-secondary); margin-top: 12px; font-style: italic; font-weight: 500;">
                    💡 Nota: Podrás marcar estos ítems como completados una vez abras la ficha del servicio.
                </p>
            </div>
            @endif

            <div style="display: flex; gap: 14px; align-items: center;">
                <a href="{{ route('groomer.agenda.index') }}" class="btn btn-secondary" style="flex: 1; justify-content: center; padding: 12px; font-size: 14px;">
                    ← Volver a Agenda
                </a>
                <button type="submit" class="btn btn-primary" style="flex: 2; justify-content: center; padding: 12px; font-size: 14px; font-weight: 700;">
                    Abrir Ficha y comenzar servicio 🐾
                </button>
            </div>
        </form>
    </div>
</div>
@endsection