@extends('layouts.dashboard')

@section('page-title', 'Solicitudes de Citas')
@section('page-subtitle', 'Citas pendientes de revisión y aprobación')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

@if($solicitudes->isEmpty())
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:56px 24px;">
        <div style="width:72px; height:72px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-check" style="font-size:32px; color:#8A9B8A;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A2E1A; margin-top:0;">No hay solicitudes pendientes</h3>
        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Todas las citas han sido revisadas.</p>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:18px;">
        @foreach($solicitudes as $cita)
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; border-left:4px solid #FF7043; padding:24px; transition:box-shadow 0.2s;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">

                <div style="display:flex; gap:18px; align-items:center;">
                    <div style="width:56px; height:56px; background:linear-gradient(135deg, #FFF3E0, #FFE0B2); border-radius:14px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-paw" style="font-size:28px; color:#E65100;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:16px; font-weight:800; color:#1A2E1A; margin:0;">{{ $cita->mascota->nombre }}</h3>
                        <p style="font-size:12px; color:#6B8F6B; margin:2px 0 0;">{{ $cita->servicio->nombre }}</p>
                        <div style="display:flex; align-items:center; gap:12px; margin-top:6px; flex-wrap:wrap;">
                            <span style="display:inline-flex; align-items:center; gap:4px; background:#F5F5F0; padding:3px 10px; border-radius:16px; font-size:11px; color:#5D6E5D;">
                                <i class="ti ti-calendar" style="font-size:11px;"></i> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                            </span>
                            <span style="display:inline-flex; align-items:center; gap:4px; background:#F5F5F0; padding:3px 10px; border-radius:16px; font-size:11px; color:#5D6E5D;">
                                <i class="ti ti-clock" style="font-size:11px;"></i> {{ $cita->fecha_hora_inicio->format('H:i') }}
                            </span>
                        </div>
                        <div style="margin-top:8px;">
                            <p style="font-size:11px; color:#8A9B8A; display:inline-flex; align-items:center; gap:4px; margin:0;">
                                <i class="ti ti-user" style="font-size:11px;"></i> Cliente: {{ $cita->creadoPor?->name ?? '—' }}
                            </p>
                            @if($cita->groomer)
                            <p style="font-size:11px; color:#8A9B8A; display:inline-flex; align-items:center; gap:4px; margin:0 0 0 12px;">
                                <i class="ti ti-scissors" style="font-size:11px;"></i> Groomer: {{ $cita->groomer->nombre }}
                            </p>
                            @endif
                        </div>
                        @if($cita->notas_cliente)
                        <div style="display:flex; align-items:center; gap:6px; margin-top:8px; background:#F9FBF6; padding:6px 12px; border-radius:10px;">
                            <i class="ti ti-notes" style="font-size:12px; #8A9B8A;"></i>
                            <span style="font-size:11px; color:#5D6E5D;">{{ $cita->notas_cliente }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                    <span style="background:#FFF3E0; color:#E65100; padding:5px 14px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="ti ti-search" style="font-size:12px;"></i> En revisión
                    </span>
                    <p style="font-size:16px; font-weight:800; color:#FF7043; margin:0; display:inline-flex; align-items:center; gap:3px;">
                        <i class="ti ti-coin" style="font-size:14px;"></i> Bs. {{ number_format($cita->precio_acordado, 2) }}
                    </p>

                    {{-- Confirmar --}}
                    <form method="POST" action="{{ route('recepcion.citas.confirmar', $cita->id) }}">
                        @csrf
                        <button type="submit" style="background:#E8F5E9; border:none; border-radius:12px; padding:8px 20px; font-size:12px; font-weight:700; color:#2E7D32; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-check" style="font-size:13px;"></i> Confirmar
                        </button>
                    </form>

                    {{-- Rechazar --}}
                    <button type="button" onclick="abrirModalCancelar({{ $cita->id }})" style="background:#FFEBEE; border:none; border-radius:12px; padding:8px 20px; font-size:12px; font-weight:700; color:#C62828; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                        <i class="ti ti-x" style="font-size:13px;"></i> Rechazar
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Modal rechazar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:32px; max-width:400px; width:90%; box-shadow:0 20px 35px -10px rgba(0,0,0,0.15); border:0.5px solid #e0e0e0;">
        <div style="text-align:center; margin-bottom:20px;">
            <div style="width:64px; height:64px; background:#FFEBEE; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                <i class="ti ti-alert-triangle" style="font-size:32px; color:#C62828;"></i>
            </div>
            <h3 style="font-size:18px; font-weight:800; color:#1A2E1A; margin:0;">Rechazar solicitud</h3>
            <p style="font-size:12px; color:#8A9B8A; margin-top:6px;">El cliente será notificado del rechazo</p>
        </div>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Motivo del rechazo..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px; font-size:13px; font-family:inherit; margin-bottom:24px; resize:none; outline:none; background:#FAFBF7; transition:all 0.2s;"
                onfocus="this.style.borderColor='#C62828'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()" style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-size:13px; font-weight:600; color:#5D6E5D; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-arrow-left" style="font-size:13px;"></i> Volver
                </button>
                <button type="submit" style="flex:1; background:linear-gradient(135deg, #EF5350, #C62828); border:none; border-radius:14px; padding:12px; font-size:13px; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:13px;"></i> Rechazar
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