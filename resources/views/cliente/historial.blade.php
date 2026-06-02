@extends('layouts.dashboard')

@section('page-title', 'Historial de Servicios')
@section('page-subtitle', 'Todos los servicios realizados a tus mascotas')

@section('content')

@if($historial->isEmpty())
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:56px 24px;">
        <div style="width:72px; height:72px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-history" style="font-size:32px; color:#8A9B8A;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A2E1A;">No tienes servicios anteriores</h3>
        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Aquí aparecerán tus citas completadas</p>
        <a href="{{ route('cliente.citas.create') }}" 
            style="display:inline-flex; align-items:center; gap:8px; margin-top:16px; background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:12px 28px; border-radius:40px; text-decoration:none; font-size:13px;">
            <i class="ti ti-calendar-plus" style="font-size:14px;"></i> Solicitar primera cita
        </a>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:18px;">
        @foreach($historial as $cita)
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:24px; transition:box-shadow 0.2s;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;">

                {{-- Info principal --}}
                <div style="display:flex; gap:18px; align-items:center;">
                    <div style="width:56px; height:56px; background:#F5F5F0; border-radius:14px; display:flex; align-items:center; justify-content:center;">
                        @if($cita->mascota->especie === 'perro')
                            <i class="ti ti-dog" style="font-size:28px; color:#4A7A4A;"></i>
                        @elseif($cita->mascota->especie === 'gato')
                            <i class="ti ti-cat" style="font-size:28px; color:#4A7A4A;"></i>
                        @else
                            <i class="ti ti-paw" style="font-size:28px; color:#4A7A4A;"></i>
                        @endif
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
                        @if($cita->groomer)
                        <p style="font-size:11px; color:#8A9B8A; margin-top:6px; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-scissors" style="font-size:11px;"></i> Atendido por: {{ $cita->groomer->nombre }}
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Estado y precio --}}
                <div style="text-align:right;">
                    @php
                        $estados = [
                            'completada'  => ['bg'=>'#F3E5F5', 'color'=>'#6A1B9A', 'icon'=>'ti-circle-check', 'label'=>'Completada'],
                            'cancelada'   => ['bg'=>'#FFEBEE', 'color'=>'#C62828', 'icon'=>'ti-x', 'label'=>'Cancelada'],
                            'no_asistio'  => ['bg'=>'#FAFAFA', 'color'=>'#757575', 'icon'=>'ti-user-off', 'label'=>'No asistió'],
                        ];
                        $c = $estados[$cita->estado] ?? ['bg'=>'#F5F5F0', 'color'=>'#8A9B8A', 'icon'=>'ti-help', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px;">
                        <i class="ti {{ $c['icon'] }}" style="font-size:11px;"></i> {{ $c['label'] }}
                    </span>
                    <p style="font-size:18px; font-weight:800; color:#FF7043; margin:8px 0 0;">
                        Bs. {{ number_format($cita->precio_acordado, 2) }}
                    </p>
                </div>
            </div>

            @if($cita->motivo_cancelacion)
            <div style="background:#FFEBEE; border-radius:12px; padding:10px 14px; margin-top:14px; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-alert-circle" style="font-size:14px; color:#C62828;"></i>
                <p style="font-size:12px; color:#C62828; margin:0; font-weight:500;">Motivo: {{ $cita->motivo_cancelacion }}</p>
            </div>
            @endif

            @if($cita->notas_cliente)
            <div style="background:#F9FBF6; border-radius:12px; padding:10px 14px; margin-top:12px; display:flex; align-items:center; gap:8px;">
                <i class="ti ti-notes" style="font-size:14px; color:#8A9B8A;"></i>
                <p style="font-size:12px; color:#5D6E5D; margin:0;">{{ $cita->notas_cliente }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Paginación (si existe) --}}
    @if(method_exists($historial, 'links'))
    <div style="margin-top:32px;">
        {{ $historial->links() }}
    </div>
    @endif
@endif

@endsection