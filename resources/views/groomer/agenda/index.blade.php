@extends('layouts.dashboard')

@section('page-title', 'Mi Agenda')
@section('page-subtitle', 'Tus citas del día y próximas')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

{{-- Citas de hoy --}}
<div style="display:flex; align-items:center; gap:10px; margin-bottom:20px;">
    <div style="width:32px; height:32px; background:linear-gradient(135deg, #1B5E20, #0D3B0D); border-radius:10px; display:flex; align-items:center; justify-content:center;">
        <i class="ti ti-sun" style="color:#fff; font-size:16px;"></i>
    </div>
    <h3 style="font-size:16px; font-weight:700; color:#1A2E1A; margin:0;">Citas de hoy — {{ now()->format('d/m/Y') }}</h3>
</div>

@if($citasHoy->isEmpty())
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:56px 24px; margin-bottom:24px;">
        <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-calendar-off" style="font-size:28px; color:#8A9B8A;"></i>
        </div>
        <p style="color:#6B8F6B; font-size:14px; font-weight:500; margin:0;">No tienes citas asignadas para hoy.</p>
        <p style="color:#8A9B8A; font-size:12px; margin-top:6px;">Disfruta de tu día libre 🧘</p>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:16px; margin-bottom:32px;">
        @foreach($citasHoy as $cita)
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:24px; transition:box-shadow 0.2s;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
                <div style="display:flex; gap:18px; align-items:center;">
                    <div style="width:56px; height:56px; background:linear-gradient(135deg, #F5F5F0, #EDEDE5); border-radius:14px; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-dog" style="font-size:28px; color:#4A7A4A;"></i>
                    </div>
                    <div>
                        <h3 style="font-size:16px; font-weight:700; color:#1A2E1A; margin:0;">{{ $cita->mascota->nombre }}</h3>
                        <p style="font-size:12px; color:#6B8F6B; margin:3px 0 0;">{{ $cita->servicio->nombre }}</p>
                        <div style="display:flex; align-items:center; gap:6px; margin-top:6px;">
                            <span style="background:#E8F5E9; color:#2E7D32; padding:3px 10px; border-radius:16px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-clock" style="font-size:11px;"></i> {{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}
                            </span>
                        </div>
                        @if($cita->mascota->alergias)
                        <div style="display:flex; align-items:center; gap:5px; margin-top:8px; background:#FFF8E1; padding:5px 10px; border-radius:10px; border:1px solid #FFE082;">
                            <i class="ti ti-alert-triangle" style="font-size:12px; color:#F57F17;"></i>
                            <span style="font-size:11px; color:#E65100; font-weight:500;">Alergias: {{ $cita->mascota->alergias }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <div style="display:flex; gap:12px; align-items:center; flex-wrap:wrap;">
                    @php
                        $colores = [
                            'agendada'    => ['bg'=>'#FFF8E1', 'color'=>'#F57F17', 'icon'=>'ti-calendar', 'label'=>'Agendada'],
                            'confirmada'  => ['bg'=>'#E8F5E9', 'color'=>'#2E7D32', 'icon'=>'ti-check', 'label'=>'Confirmada'],
                            'en_progreso' => ['bg'=>'#E3F2FD', 'color'=>'#1565C0', 'icon'=>'ti-progress', 'label'=>'En progreso'],
                            'completada'  => ['bg'=>'#F3E5F5', 'color'=>'#6A1B9A', 'icon'=>'ti-circle-check', 'label'=>'Completada'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'#F5F5F0', 'color'=>'#6B8F6B', 'icon'=>'ti-help', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:6px 14px; border-radius:20px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="ti {{ $c['icon'] }}" style="font-size:12px;"></i> {{ $c['label'] }}
                    </span>

                    <div style="display:flex; gap:8px;">
                        @if(in_array($cita->estado, ['confirmada', 'agendada']))
                        <a href="{{ route('groomer.ficha.create', $cita->id) }}" style="background:#1B5E20; border:none; border-radius:12px; padding:8px 18px; font-size:12px; font-weight:600; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-file-description" style="font-size:13px;"></i> Abrir Ficha
                        </a>
                        @elseif($cita->estado === 'en_progreso')
                        <a href="{{ route('groomer.ficha.create', $cita->id) }}" style="background:linear-gradient(135deg, #1565C0, #0D47A1); border:none; border-radius:12px; padding:8px 18px; font-size:12px; font-weight:600; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                            <i class="ti ti-eye" style="font-size:13px;"></i> Ver Ficha
                        </a>
                        @endif

                        @if(!in_array($cita->estado, ['cancelada', 'completada']))
                        <button type="button" onclick="abrirModalCancelar({{ $cita->id }})" style="background:#fff; border:1.5px solid #FFCDD2; border-radius:12px; padding:8px 16px; font-size:12px; font-weight:600; color:#C62828; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-x" style="font-size:13px;"></i> Cancelar
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
<div style="display:flex; align-items:center; gap:10px; margin-bottom:20px; margin-top:8px;">
    <div style="width:32px; height:32px; background:linear-gradient(135deg, #1565C0, #0D3B5E); border-radius:10px; display:flex; align-items:center; justify-content:center;">
        <i class="ti ti-calendar-week" style="color:#fff; font-size:16px;"></i>
    </div>
    <h3 style="font-size:16px; font-weight:700; color:#1A2E1A; margin:0;">Próximas citas</h3>
</div>

<div style="display:flex; flex-direction:column; gap:12px;">
    @foreach($citasPendientes as $cita)
    <div style="background:#fff; border-radius:16px; border:0.5px solid #e0e0e0; padding:18px 20px; opacity:0.85; border-style:dashed;">
        <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">
            <div style="display:flex; gap:14px; align-items:center;">
                <div style="width:44px; height:44px; background:#F5F5F0; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="ti ti-paw" style="font-size:22px; color:#8A9B8A;"></i>
                </div>
                <div>
                    <p style="font-weight:700; color:#1A2E1A; margin:0;">{{ $cita->mascota->nombre }}</p>
                    <p style="font-size:12px; color:#6B8F6B; margin:2px 0 0;">{{ $cita->servicio->nombre }}</p>
                    <div style="display:flex; align-items:center; gap:5px; margin-top:4px;">
                        <i class="ti ti-calendar" style="font-size:11px; color:#1565C0;"></i>
                        <span style="font-size:11px; color:#1565C0; font-weight:600;">{{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:32px; max-width:420px; width:90%; text-align:center; box-shadow:0 20px 35px -10px rgba(0,0,0,0.15); border:0.5px solid #e0e0e0;">
        <div style="width:64px; height:64px; background:#FFEBEE; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-alert-circle" style="font-size:32px; color:#C62828;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:800; color:#1A2E1A; margin-bottom:8px;">Cancelar cita</h3>
        <p style="font-size:13px; color:#6B8F6B; margin-bottom:24px;">Por favor, indica un motivo válido para la cancelación de esta sesión.</p>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Escribe aquí el motivo del descarte (mínimo 10 caracteres)..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:12px; padding:12px; font-size:13px; font-family:inherit; margin-bottom:20px; resize:none; outline:none; background:#FAFBF7; transition:all 0.2s;"
                onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'" 
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()" style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:11px; font-size:13px; font-weight:600; color:#5D6E5D; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-arrow-left" style="font-size:13px;"></i> Volver
                </button>
                <button type="submit" style="flex:1; background:#C62828; border:none; border-radius:14px; padding:11px; font-size:13px; font-weight:700; color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px;">
                    <i class="ti ti-x" style="font-size:13px;"></i> Confirmar baja
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