@extends('layouts.dashboard')

@section('page-title', '📅 Mi Agenda')
@section('page-subtitle', 'Tus citas del día y próximas')

@section('content')

@if(session('status'))
    <div class="alert alert-success">
        ✅ {{ session('status') }}
    </div>
@endif

{{-- Citas de hoy --}}
<h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-bottom: 16px; font-family: 'Plus Jakarta Sans', sans-serif;">
    🌅 Citas de hoy — {{ now()->format('d/m/Y') }}
</h3>

@if($citasHoy->isEmpty())
    <div class="stat-card" style="text-align: center; padding: 48px; margin-bottom: 24px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <div style="font-size: 48px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.05));">😴</div>
        <p style="color: var(--text-secondary); margin-top: 12px; font-weight: 500;">No tienes citas asignadas para hoy.</p>
    </div>
@else
    <div style="display: flex; flex-direction: column; gap: 14px; margin-bottom: 32px;">
        @foreach($citasHoy as $cita)
        <div class="stat-card" style="padding: 24px;">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div style="display: flex; gap: 18px; align-items: center;">
                    <div style="font-size: 38px; width: 56px; height: 56px; background: var(--bg); display: grid; place-items: center; border-radius: var(--radius-md);">
                        @if($cita->mascota->especie === 'perro') 🐶
                        @elseif($cita->mascota->especie === 'gato') 🐱
                        @else 🐾
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); font-family: 'Plus Jakarta Sans', sans-serif;">{{ $cita->mascota->nombre }}</h3>
                        <p style="font-size: 13px; color: var(--text-secondary); font-weight: 500; margin-top: 1px;">{{ $cita->servicio->nombre }}</p>
                        <p style="font-size: 12px; color: var(--brand); font-weight: 600; margin-top: 4px; display: inline-flex; align-items: center; gap: 4px; background: var(--brand-light); padding: 2px 8px; border-radius: 6px;">
                            🕐 {{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}
                        </p>
                        @if($cita->mascota->alergias)
                        <p style="font-size: 12px; color: #c2410c; background: #fff7ed; border: 1px solid #ffedd5; padding: 4px 10px; border-radius: 6px; margin-top: 6px; font-weight: 500;">
                            ⚠️ Alergias: {{ $cita->mascota->alergias }}
                        </p>
                        @endif
                    </div>
                </div>

                <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;">
                    @php
                        $colores = [
                            'agendada'    => ['bg'=>'#fef3c7', 'color'=>'#d97706', 'label'=>'⏳ Agendada'],
                            'confirmada'  => ['bg'=>'#dcfce7', 'color'=>'#15803d', 'label'=>'✅ Confirmada'],
                            'en_progreso' => ['bg'=>'#e0f2fe', 'color'=>'#0369a1', 'label'=>'🔄 En progreso'],
                            'completada'  => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🎉 Completada'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'var(--bg)', 'color'=>'var(--text-secondary)', 'label'=>$cita->estado];
                    @endphp
                    <span style="background: {{ $c['bg'] }}; color: {{ $c['color'] }}; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.3px;">
                        {{ $c['label'] }}
                    </span>

                    <div style="display: flex; gap: 8px;">
                        {{-- Abrir ficha si está confirmada o agendada --}}
                        @if(in_array($cita->estado, ['confirmada', 'agendada']))
                        <a href="{{ route('groomer.ficha.create', $cita->id) }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 13px;">
                            📋 Abrir Ficha
                        </a>
                        @elseif($cita->estado === 'en_progreso')
                        <a href="{{ route('groomer.ficha.create', $cita->id) }}" class="btn" style="background: linear-gradient(135deg, #0284c7, #0369a1); color: white; padding: 8px 16px; font-size: 13px; box-shadow: 0 4px 12px rgba(3,105,161,0.2);">
                            📋 Ver Ficha
                        </a>
                        @endif

                        {{-- Cancelar si no está completada --}}
                        @if(!in_array($cita->estado, ['cancelada', 'completada']))
                        <button type="button" onclick="abrirModalCancelar({{ $cita->id }})" class="btn btn-danger" style="padding: 8px 14px; font-size: 13px;">
                            ❌ Cancelar
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Próximas citas --}}
@if($citasPendientes->isNotEmpty())
<h3 style="font-size: 18px; font-weight: 700; color: var(--text-primary); margin-top: 24px; margin-bottom: 16px; font-family: 'Plus Jakarta Sans', sans-serif;">
    📆 Próximas citas
</h3>
<div style="display: flex; flex-direction: column; gap: 12px;">
    @foreach($citasPendientes as $cita)
    <div class="stat-card" style="opacity: 0.85; border-style: dashed;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; gap: 16px; align-items: center;">
                <div style="font-size: 28px; width: 44px; height: 44px; background: var(--bg); display: grid; place-items: center; border-radius: var(--radius-sm);">
                    @if($cita->mascota->especie === 'perro') 🐶
                    @elseif($cita->mascota->especie === 'gato') 🐱
                    @else 🐾
                    @endif
                </div>
                <div>
                    <p style="font-weight: 700; color: var(--text-primary);">{{ $cita->mascota->nombre }}</p>
                    <p style="font-size: 13px; color: var(--text-secondary);">{{ $cita->servicio->nombre }}</p>
                    <p style="font-size: 12px; color: var(--brand); font-weight: 600; margin-top: 2px;">📅 {{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display: none; position: fixed; inset: 0; background: rgba(26, 46, 26, 0.4); backdrop-filter: blur(4px); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: var(--surface); border-radius: var(--radius-lg); padding: 32px; max-width: 420px; width: 90%; text-align: center; box-shadow: var(--shadow-lg); border: 1px solid var(--border);">
        <div style="font-size: 40px; margin-bottom: 14px; width: 64px; height: 64px; background: #fef2f2; display: grid; place-items: center; border-radius: 50%; margin-left: auto; margin-right: auto; color: #dc2626;">✕</div>
        <h3 style="font-size: 19px; font-weight: 700; color: var(--text-primary); margin-bottom: 8px; font-family: 'Plus Jakarta Sans', sans-serif;">Cancelar cita</h3>
        <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 20px;">Por favor, indica un motivo válido para la cancelación de esta sesión.</p>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Escribe aquí el motivo del descarte (mínimo 10 caracteres)..."
                style="width: 100%; border: 1.5px solid var(--border); border-radius: var(--radius-md); padding: 12px; font-size: 13px; font-family: 'DM Sans', sans-serif; margin-bottom: 20px; resize: none; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='var(--brand)'" onblur="this.style.borderColor='var(--border)'"></textarea>
            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="cerrarModalCancelar()" class="btn btn-secondary" style="flex: 1; justify-content: center; padding: 11px;">
                    Volver
                </button>
                <button type="submit" class="btn" style="flex: 1; justify-content: center; background: #dc2626; color: white; font-weight: 600; padding: 11px; box-shadow: 0 4px 12px rgba(220,38,38,0.15);">
                    Confirmar baja
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalCancelar(id) {
    document.getElementById('form-cancelar').action = '/groomer/agenda/' + id + '/cancelar';
    document.getElementById('modal-cancelar').style.display = 'flex';
}
function cerrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}
</script>
@endsection