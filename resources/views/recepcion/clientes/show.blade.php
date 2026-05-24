@extends('layouts.dashboard')

@section('page-title', '👤 Detalle del Cliente')
@section('page-subtitle', 'Información completa del cliente y sus mascotas')

@section('content')

<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">

    {{-- Info del cliente --}}
    <div class="stat-card">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">👤 Datos del cliente</h3>
        <div style="display:flex; flex-direction:column; gap:8px;">
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f0eb;">
                <span style="font-size:13px; color:#a1887f;">Nombre</span>
                <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $cliente->nombre }} {{ $cliente->apellido }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f0eb;">
                <span style="font-size:13px; color:#a1887f;">Email</span>
                <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $cliente->usuario->email }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f0eb;">
                <span style="font-size:13px; color:#a1887f;">Teléfono</span>
                <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $cliente->telefono ?? '—' }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #f5f0eb;">
                <span style="font-size:13px; color:#a1887f;">CI</span>
                <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $cliente->usuario->ci ?? '—' }}</span>
            </div>
            <div style="display:flex; justify-content:space-between; padding:8px 0;">
                <span style="font-size:13px; color:#a1887f;">Dirección</span>
                <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $cliente->direccion ?? '—' }}</span>
            </div>
        </div>
    </div>

    {{-- Mascotas --}}
    <div class="stat-card">
        <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">🐾 Mascotas</h3>
        <a href="{{ route('recepcion.clientes.mascota.create', $cliente->id) }}" class="btn btn-primary" style="font-size:12px; padding:6px 14px; margin-bottom:12px; display:inline-block;">
    🐾 Agregar mascota
</a>
        @forelse($cliente->mascotas as $mascota)
        <div style="background:#f5f0eb; border-radius:10px; padding:12px; margin-bottom:8px;">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div style="display:flex; gap:8px; align-items:center;">
                    <span style="font-size:24px;">
                        @if($mascota->especie === 'perro') 🐶
                        @elseif($mascota->especie === 'gato') 🐱
                        @else 🐾
                        @endif
                    </span>
                    <div>
                        <p style="font-weight:700; color:#5d4037; font-size:14px;">{{ $mascota->nombre }}</p>
                        <p style="font-size:12px; color:#a1887f;">{{ ucfirst($mascota->especie) }} — {{ strtoupper($mascota->tamano) }} — {{ $mascota->peso_kg }}kg</p>
                    </div>
                </div>
            </div>
            @if($mascota->alergias)
            <p style="font-size:12px; color:#e65100; margin-top:6px;">⚠️ {{ $mascota->alergias }}</p>
            @endif
            @if($mascota->vacunas->isNotEmpty())
            <div style="margin-top:8px;">
                @foreach($mascota->vacunas as $vacuna)
                <span style="background:{{ $vacuna->estaVigente() ? '#e8f5e9' : '#ffebee' }}; color:{{ $vacuna->estaVigente() ? '#2e7d32' : '#c62828' }}; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600; margin-right:4px;">
                    💉 {{ $vacuna->nombre_vacuna }}
                </span>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <p style="color:#a1887f; font-size:13px;">Sin mascotas registradas.</p>
        @endforelse
    </div>
</div>

{{-- Historial de citas --}}
<div class="stat-card">
    <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">📅 Historial de citas</h3>
    @forelse($citas as $cita)
    <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 0; border-bottom:1px solid #f5f0eb;">
        <div style="display:flex; gap:12px; align-items:center;">
            <span style="font-size:24px;">
                @if($cita->mascota->especie === 'perro') 🐶
                @elseif($cita->mascota->especie === 'gato') 🐱
                @else 🐾
                @endif
            </span>
            <div>
                <p style="font-weight:600; color:#5d4037; font-size:13px;">{{ $cita->mascota->nombre }} — {{ $cita->servicio->nombre }}</p>
                <p style="font-size:12px; color:#a1887f;">{{ $cita->fecha_hora_inicio->format('d/m/Y H:i') }} — {{ $cita->groomer?->nombre ?? 'Sin groomer' }}</p>
            </div>
        </div>
        <div style="text-align:right;">
            @php
                $colores = [
                    'completada'  => ['bg'=>'#f3e5f5','color'=>'#6a1b9a','label'=>'🎉 Completada'],
                    'cancelada'   => ['bg'=>'#ffebee','color'=>'#c62828','label'=>'❌ Cancelada'],
                    'confirmada'  => ['bg'=>'#e8f5e9','color'=>'#2e7d32','label'=>'✅ Confirmada'],
                    'agendada'    => ['bg'=>'#fff3e0','color'=>'#e65100','label'=>'⏳ Agendada'],
                    'en_progreso' => ['bg'=>'#e3f2fd','color'=>'#1565c0','label'=>'🔄 En progreso'],
                ];
                $c = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5','color'=>'#333','label'=>$cita->estado];
            @endphp
            <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                {{ $c['label'] }}
            </span>
            <p style="font-size:13px; font-weight:700; color:#ff7043; margin-top:4px;">Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
        </div>
    </div>
    @empty
    <p style="color:#a1887f; font-size:13px;">Sin citas registradas.</p>
    @endforelse
</div>

<div style="margin-top:16px;">
    <a href="{{ route('recepcion.clientes.index') }}"
        style="background:#f5f0eb; color:#8d6e63; font-weight:600; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:14px;">
        ← Volver a clientes
    </a>
</div>

@endsection