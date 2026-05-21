@extends('layouts.dashboard')

@section('page-title', '🔍 Solicitudes de Citas')
@section('page-subtitle', 'Citas pendientes de revisión y aprobación')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

@if($solicitudes->isEmpty())
    <div class="stat-card" style="text-align:center; padding:48px;">
        <div style="font-size:64px;">✅</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-top:16px;">No hay solicitudes pendientes</h3>
        <p style="color:#a1887f; margin-top:8px;">Todas las citas han sido revisadas.</p>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:16px;">
        @foreach($solicitudes as $cita)
        <div class="stat-card" style="border-left:4px solid #ff7043;">
            <div style="display:flex; justify-content:space-between; align-items:start; flex-wrap:wrap; gap:12px;">

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
                        <p style="font-size:13px; color:#8d6e63; margin-top:4px;">
                            📅 {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                            🕐 {{ $cita->fecha_hora_inicio->format('H:i') }}
                        </p>
                        <p style="font-size:12px; color:#a1887f;">
                            👤 Cliente: {{ $cita->creadoPor?->name ?? '—' }}
                        </p>
                        @if($cita->groomer)
                        <p style="font-size:12px; color:#a1887f;">
                            ✂️ Groomer: {{ $cita->groomer->nombre }}
                        </p>
                        @endif
                        @if($cita->notas_cliente)
                        <p style="font-size:12px; color:#8d6e63; margin-top:4px;">
                            📝 {{ $cita->notas_cliente }}
                        </p>
                        @endif
                    </div>
                </div>

                <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                    <span style="background:#f3e5f5; color:#6a1b9a; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">
                        🔍 En revisión
                    </span>
                    <p style="font-size:14px; font-weight:700; color:#ff7043;">
                        Bs. {{ number_format($cita->precio_acordado, 2) }}
                    </p>

                    {{-- Confirmar --}}
                    <form method="POST" action="{{ route('recepcion.citas.confirmar', $cita->id) }}">
                        @csrf
                        <button type="submit"
                            style="background:#e8f5e9; color:#2e7d32; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                            ✅ Confirmar
                        </button>
                    </form>

                    {{-- Cancelar --}}
                    <button type="button"
                        onclick="abrirModalCancelar({{ $cita->id }})"
                        style="background:#ffebee; color:#c62828; border:none; padding:8px 16px; border-radius:8px; font-size:13px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                        ❌ Rechazar
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:400px; width:90%;">
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:16px; text-align:center;">❌ Rechazar solicitud</h3>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Motivo del rechazo..."
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px; font-size:13px; font-family:Poppins,sans-serif; margin-bottom:16px; resize:none; outline:none;"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()"
                    style="flex:1; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Volver
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg,#ef5350,#e53935); color:white; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Rechazar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function abrirModalCancelar(id) {
    document.getElementById('form-cancelar').action = '/recepcion/citas/' + id + '/cancelar';
    document.getElementById('modal-cancelar').style.display = 'flex';
}
function cerrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}
</script>

@endsection