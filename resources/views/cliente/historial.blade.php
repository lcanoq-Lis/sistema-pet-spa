@extends('layouts.dashboard')

@section('page-title', '📋 Historial de Servicios')
@section('page-subtitle', 'Todos los servicios realizados a tus mascotas')

@section('content')

@if($historial->isEmpty())
    <div class="stat-card" style="text-align:center; padding:48px;">
        <div style="font-size:64px;">📋</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-top:16px;">No tienes servicios anteriores</h3>
        <p style="color:#a1887f; margin-top:8px; font-size:14px;">Aquí aparecerán tus citas completadas</p>
    </div>
@else
    <div style="display:flex; flex-direction:column; gap:16px;">
        @foreach($historial as $cita)
        <div class="stat-card">
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
                        @if($cita->groomer)
                        <p style="font-size:12px; color:#a1887f; margin-top:2px;">
                            ✂️ Atendido por: {{ $cita->groomer->nombre }}
                        </p>
                        @endif
                    </div>
                </div>

                <div style="text-align:right;">
                    @php
                        $colores = [
                            'completada'  => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🎉 Completada'],
                            'cancelada'   => ['bg'=>'#ffebee', 'color'=>'#c62828', 'label'=>'❌ Cancelada'],
                            'no_asistio'  => ['bg'=>'#fafafa',  'color'=>'#757575', 'label'=>'😔 No asistió'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5', 'color'=>'#333', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:600;">
                        {{ $c['label'] }}
                    </span>
                    <p style="font-size:16px; font-weight:700; color:#5d4037; margin-top:8px;">
                        Bs. {{ number_format($cita->precio_acordado, 2) }}
                    </p>
                </div>
            </div>

            @if($cita->motivo_cancelacion)
            <div style="background:#ffebee; border-radius:8px; padding:8px 12px; margin-top:12px;">
                <p style="font-size:12px; color:#c62828;">❌ Motivo: {{ $cita->motivo_cancelacion }}</p>
            </div>
            @endif

            @if($cita->notas_cliente)
            <div style="background:#f5f0eb; border-radius:8px; padding:8px 12px; margin-top:8px;">
                <p style="font-size:12px; color:#8d6e63;">📝 {{ $cita->notas_cliente }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
@endif

@endsection