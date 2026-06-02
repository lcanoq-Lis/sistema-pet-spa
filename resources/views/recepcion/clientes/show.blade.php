@extends('layouts.dashboard')

@section('page-title', 'Detalle del Cliente')
@section('page-subtitle', 'Información completa del cliente y sus mascotas')

@section('content')

<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:24px;">

    {{-- Info del cliente --}}
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #1B5E20, #0D3B0D); padding:16px 24px; display:flex; align-items:center; gap:12px;">
            <div style="width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                <i class="ti ti-user" style="font-size:20px; color:#fff;"></i>
            </div>
            <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Datos del cliente</h3>
        </div>
        <div style="padding:24px;">
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #F0F0EA;">
                <span style="font-size:13px; color:#8A9B8A; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-user" style="font-size:12px;"></i> Nombre
                </span>
                <span style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $cliente->nombre }} {{ $cliente->apellido }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #F0F0EA;">
                <span style="font-size:13px; color:#8A9B8A; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-mail" style="font-size:12px;"></i> Email
                </span>
                <span style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $cliente->usuario->email }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #F0F0EA;">
                <span style="font-size:13px; color:#8A9B8A; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-phone" style="font-size:12px;"></i> Teléfono
                </span>
                <span style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $cliente->telefono ?? '—' }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px 0; border-bottom:1px solid #F0F0EA;">
                <span style="font-size:13px; color:#8A9B8A; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-id-badge" style="font-size:12px;"></i> CI
                </span>
                <span style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $cliente->usuario->ci ?? '—' }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:12px 0;">
                <span style="font-size:13px; color:#8A9B8A; display:flex; align-items:center; gap:6px;">
                    <i class="ti ti-map-pin" style="font-size:12px;"></i> Dirección
                </span>
                <span style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $cliente->direccion ?? '—' }}</span>
            </div>
        </div>
    </div>

    {{-- Mascotas --}}
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
        <div style="background:linear-gradient(135deg, #FF7043, #F57F17); padding:16px 24px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; align-items:center; gap:12px;">
                <div style="width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="ti ti-paw" style="font-size:20px; color:#fff;"></i>
                </div>
                <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Mascotas</h3>
            </div>
            <a href="{{ route('recepcion.clientes.mascota.create', $cliente->id) }}" 
                style="background:rgba(255,255,255,0.2); border:none; border-radius:40px; padding:8px 16px; font-size:12px; font-weight:600; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
                <i class="ti ti-plus" style="font-size:13px;"></i> Agregar mascota
            </a>
        </div>
        <div style="padding:24px;">
            @forelse($cliente->mascotas as $mascota)
            <div style="background:#F9FBF6; border-radius:16px; padding:16px; margin-bottom:12px; border:1px solid #E0E5D9;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div style="display:flex; gap:12px; align-items:center;">
                        <div style="width:48px; height:48px; background:linear-gradient(135deg, #FFF3E0, #FFE0B2); border-radius:14px; display:flex; align-items:center; justify-content:center;">
                            <i class="ti ti-dog" style="font-size:24px; color:#F57F17;"></i>
                        </div>
                        <div>
                            <p style="font-weight:800; color:#1A2E1A; font-size:15px; margin:0;">{{ $mascota->nombre }}</p>
                            <p style="font-size:11px; color:#8A9B8A; margin:2px 0 0;">
                                {{ ucfirst($mascota->especie) }} · {{ strtoupper($mascota->tamano) }} · {{ $mascota->peso_kg }}kg
                            </p>
                        </div>
                    </div>
                </div>
                @if($mascota->alergias)
                <div style="display:flex; align-items:center; gap:6px; margin-top:12px; background:#FFF8E1; padding:8px 12px; border-radius:10px;">
                    <i class="ti ti-alert-triangle" style="font-size:12px; color:#F57F17;"></i>
                    <span style="font-size:11px; color:#E65100; font-weight:500;">{{ $mascota->alergias }}</span>
                </div>
                @endif
                @if($mascota->vacunas->isNotEmpty())
                <div style="margin-top:10px; display:flex; gap:6px; flex-wrap:wrap;">
                    @foreach($mascota->vacunas as $vacuna)
                    <span style="background:{{ $vacuna->estaVigente() ? '#E8F5E9' : '#FFEBEE' }}; color:{{ $vacuna->estaVigente() ? '#2E7D32' : '#C62828' }}; padding:4px 10px; border-radius:20px; font-size:10px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                        <i class="ti ti-vaccine" style="font-size:10px;"></i> {{ $vacuna->nombre_vacuna }}
                    </span>
                    @endforeach
                </div>
                @endif
            </div>
            @empty
            <div style="text-align:center; padding:32px;">
                <div style="width:56px; height:56px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                    <i class="ti ti-dog" style="font-size:24px; color:#8A9B8A;"></i>
                </div>
                <p style="color:#8A9B8A; font-size:13px; margin:0;">Sin mascotas registradas.</p>
                <a href="{{ route('recepcion.clientes.mascota.create', $cliente->id) }}" style="display:inline-flex; align-items:center; gap:6px; margin-top:10px; color:#FF7043; font-size:12px; font-weight:600; text-decoration:none;">
                    <i class="ti ti-plus"></i> Agregar primera mascota
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Historial de citas --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden;">
    <div style="background:linear-gradient(135deg, #1565C0, #0D3B5E); padding:16px 24px; display:flex; align-items:center; gap:12px;">
        <div style="width:36px; height:36px; background:rgba(255,255,255,0.15); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-calendar-stats" style="font-size:20px; color:#fff;"></i>
        </div>
        <h3 style="font-size:15px; font-weight:700; color:#fff; margin:0;">Historial de citas</h3>
    </div>
    <div style="padding:20px;">
        @forelse($citas as $cita)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:14px 0; border-bottom:1px solid #F0F0EA; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; gap:14px; align-items:center;">
                <div style="width:44px; height:44px; background:#F5F5F0; border-radius:12px; display:flex; align-items:center; justify-content:center;">
                    <i class="ti ti-calendar" style="font-size:20px; color:#8A9B8A;"></i>
                </div>
                <div>
                    <p style="font-weight:700; color:#1A2E1A; font-size:14px; margin:0;">
                        {{ $cita->mascota->nombre }} — {{ $cita->servicio->nombre }}
                    </p>
                    <p style="font-size:11px; color:#8A9B8A; margin:3px 0 0; display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                        <span style="display:inline-flex; align-items:center; gap:3px;"><i class="ti ti-clock" style="font-size:10px;"></i> {{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }}</span>
                        <span style="display:inline-flex; align-items:center; gap:3px;"><i class="ti ti-scissors" style="font-size:10px;"></i> {{ $cita->groomer?->nombre ?? 'Sin groomer' }}</span>
                    </p>
                </div>
            </div>
            <div style="text-align:right;">
                @php
                    $colores = [
                        'completada'  => ['bg'=>'#F3E5F5','color'=>'#6A1B9A','icon'=>'ti-circle-check','label'=>'Completada'],
                        'cancelada'   => ['bg'=>'#FFEBEE','color'=>'#C62828','icon'=>'ti-x','label'=>'Cancelada'],
                        'confirmada'  => ['bg'=>'#E8F5E9','color'=>'#2E7D32','icon'=>'ti-check','label'=>'Confirmada'],
                        'agendada'    => ['bg'=>'#FFF8E1','color'=>'#F57F17','icon'=>'ti-calendar','label'=>'Agendada'],
                        'en_progreso' => ['bg'=>'#E3F2FD','color'=>'#1565C0','icon'=>'ti-progress','label'=>'En progreso'],
                    ];
                    $c = $colores[$cita->estado] ?? ['bg'=>'#F5F5F0','color'=>'#8A9B8A','icon'=>'ti-help','label'=>$cita->estado];
                @endphp
                <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:4px 12px; border-radius:30px; font-size:10px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                    <i class="ti {{ $c['icon'] }}" style="font-size:10px;"></i> {{ $c['label'] }}
                </span>
                <p style="font-size:14px; font-weight:800; color:#FF7043; margin:6px 0 0;">Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
            </div>
        </div>
        @empty
        <div style="text-align:center; padding:40px;">
            <div style="width:56px; height:56px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                <i class="ti ti-calendar-off" style="font-size:24px; color:#8A9B8A;"></i>
            </div>
            <p style="color:#8A9B8A; font-size:13px; margin:0;">Sin citas registradas.</p>
        </div>
        @endforelse
    </div>
</div>

<div style="margin-top:24px;">
    <a href="{{ route('recepcion.clientes.index') }}" 
        style="background:#fff; border:1.5px solid #e0e0e0; border-radius:40px; padding:12px 24px; font-weight:600; color:#5D6E5D; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
        <i class="ti ti-arrow-left" style="font-size:14px;"></i> Volver a clientes
    </a>
</div>

@endsection