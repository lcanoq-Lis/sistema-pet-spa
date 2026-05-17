@extends('layouts.dashboard')

@section('page-title', '📅 Mi Agenda')
@section('page-subtitle', 'Tus citas del día y próximas')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

{{-- Citas de hoy --}}
<h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:16px;">
    🌅 Citas de hoy — {{ now()->format('d/m/Y') }}
</h3>

@if($citasHoy->isEmpty())
    <div class="stat-card" style="text-align:center; padding:32px; margin-bottom:24px;">
        <div style="font-size:48px;">😴</div>
        <p style="color:#a1887f; margin-top:8px;">No tienes citas para hoy.</p>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:32px;">
        @foreach($citasHoy as $cita)
        <div class="stat-card">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <div style="display:flex; gap:16px; align-items:center;">
                    <div style="font-size:40px;">
                        @if($cita->mascota->especie === 'perro') 🐶
                        @elseif($cita->mascota->especie === 'gato') 🐱
                        @else 🐾
                        @endif
                    </div>
                    <div>
                        <h3 style="font-size:16px; font-weight:700; color:#5d4037;">{{ $cita->mascota->nombre }}</h3>
                        <p style="font-size:13px; color:#a1887f;">{{ $cita->servicio->nombre }}</p>
                        <p style="font-size:13px; color:#8d6e63;">
                            🕐 {{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}
                        </p>
                        @if($cita->mascota->alergias)
                        <p style="font-size:12px; color:#e65100; margin-top:4px;">⚠️ Alergias: {{ $cita->mascota->alergias }}</p>
                        @endif
                    </div>
                </div>

                <div style="display:flex; gap:8px; align-items:center;">
                    @php
                        $colores = [
                            'agendada'    => ['bg'=>'#fff3e0', 'color'=>'#e65100', 'label'=>'⏳ Agendada'],
                            'confirmada'  => ['bg'=>'#e8f5e9', 'color'=>'#2e7d32', 'label'=>'✅ Confirmada'],
                            'en_progreso' => ['bg'=>'#e3f2fd', 'color'=>'#1565c0', 'label'=>'🔄 En progreso'],
                            'completada'  => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🎉 Completada'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5', 'color'=>'#333', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">
                        {{ $c['label'] }}
                    </span>

                   <div style="display:flex; gap:8px; flex-wrap:wrap;">

    {{-- Abrir ficha si está confirmada o en progreso --}}
    @if(in_array($cita->estado, ['confirmada', 'agendada']))
    <a href="{{ route('groomer.ficha.create', $cita->id) }}"
        style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:8px 16px; border-radius:8px; text-decoration:none; font-size:13px;">
        📋 Abrir Ficha
    </a>
    @elseif($cita->estado === 'en_progreso')
    <a href="{{ route('groomer.ficha.create', $cita->id) }}"
        style="background:linear-gradient(135deg,#1565c0,#1976d2); color:white; font-weight:600; padding:8px 16px; border-radius:8px; text-decoration:none; font-size:13px;">
        📋 Ver Ficha
    </a>
    @endif

    {{-- Cancelar si no está completada --}}
    @if(!in_array($cita->estado, ['cancelada', 'completada']))
    <button type="button"
        onclick="abrirModalCancelar({{ $cita->id }})"
        style="background:#ffebee; color:#c62828; border:none; padding:8px 14px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
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
<h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:16px;">
    📆 Próximas citas
</h3>
<div style="display:flex; flex-direction:column; gap:12px;">
    @foreach($citasPendientes as $cita)
    <div class="stat-card" style="opacity:0.8;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div style="display:flex; gap:16px; align-items:center;">
                <div style="font-size:32px;">
                    @if($cita->mascota->especie === 'perro') 🐶
                    @elseif($cita->mascota->especie === 'gato') 🐱
                    @else 🐾
                    @endif
                </div>
                <div>
                    <p style="font-weight:700; color:#5d4037;">{{ $cita->mascota->nombre }}</p>
                    <p style="font-size:13px; color:#a1887f;">{{ $cita->servicio->nombre }}</p>
                    <p style="font-size:12px; color:#8d6e63;">📅 {{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif
{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:400px; width:90%; text-align:center;">
        <div style="font-size:48px; margin-bottom:16px;">❌</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:8px;">Cancelar cita</h3>
        <p style="font-size:13px; color:#a1887f; margin-bottom:16px;">Indica el motivo de cancelación.</p>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Motivo de cancelación (mínimo 10 caracteres)..."
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px; font-size:13px; font-family:Poppins,sans-serif; margin-bottom:16px; resize:none; outline:none;"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()"
                    style="flex:1; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Volver
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg,#ef5350,#e53935); color:white; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Cancelar cita
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