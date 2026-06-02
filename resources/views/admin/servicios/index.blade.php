@extends('layouts.dashboard')

@section('page-title', 'Servicios')
@section('page-subtitle', 'Gestión de servicios y precios')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; color:#2E7D32; border-left:4px solid #43A047; padding:14px 18px; border-radius:12px; margin-bottom:20px; font-size:13px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="font-size:18px;"></i> {{ session('status') }}
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:18px; font-weight:700; color:#5D4037; display:flex; align-items:center; gap:8px;">
        <i class="ti ti-scissors" style="font-size:20px; color:#2E7D32;"></i> Servicios
    </h2>
    <a href="{{ route('admin.servicios.create') }}"
        style="background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:600; padding:10px 20px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
        <i class="ti ti-plus" style="font-size:16px;"></i> Nuevo Servicio
    </a>
</div>

<div class="stat-card" style="padding:0; overflow-x:auto; border-radius:20px;">
    <table style="width:100%; border-collapse:collapse; min-width:800px;">
        <thead>
            <tr style="background:linear-gradient(135deg,#2E7D32,#43A047);">
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-tag" style="font-size:14px;"></i> Servicio</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-coin" style="font-size:14px;"></i> Precio base</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-clock" style="font-size:14px;"></i> Duración</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-ruler" style="font-size:14px;"></i> Precio por tamaño</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-status-change" style="font-size:14px;"></i> Estado</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-settings" style="font-size:14px;"></i> Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($servicios as $servicio)
            <tr style="border-bottom:1px solid #F5F0EB; background:{{ $loop->even ? '#FAFAFA' : 'white' }}; transition:background 0.2s;">
                <td style="padding:14px 16px;">
                    <p style="font-weight:700; color:#5D4037; font-size:14px; margin:0 0 4px; display:flex; align-items:center; gap:6px;">
                        <i class="ti ti-paw" style="color:#2E7D32; font-size:14px;"></i> {{ $servicio->nombre }}
                    </p>
                    <p style="font-size:11px; color:#A1887F; margin:0;">{{ Str::limit($servicio->descripcion, 50) }}</p>
                </td>
                <td style="padding:14px 16px; font-weight:700; color:#2E7D32; font-size:15px;">
                    Bs. {{ number_format($servicio->precio_base, 2) }}
                </td>
                <td style="padding:14px 16px; font-size:12px; color:#5D4037;">
                    <i class="ti ti-hourglass" style="font-size:12px;"></i> {{ $servicio->duracion_base_minutos }} min
                </td>
                <td style="padding:14px 16px;">
                    @php $factores = $servicio->factor_tamano_raza ?? []; @endphp
                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                        @foreach(['xs','s','m','l','xl'] as $tam)
                        <span style="background:#E8F5E9; color:#2E7D32; padding:4px 10px; border-radius:40px; font-size:10px; font-weight:600;">
                            {{ strtoupper($tam) }}: Bs. {{ number_format($servicio->precio_base * ($factores[$tam] ?? 1), 0) }}
                        </span>
                        @endforeach
                    </div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:{{ $servicio->activo ? '#E8F5E9' : '#FFEBEE' }}; color:{{ $servicio->activo ? '#2E7D32' : '#C62828' }}; padding:4px 12px; border-radius:40px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <i class="ti {{ $servicio->activo ? 'ti-circle-check' : 'ti-circle-x' }}" style="font-size:10px;"></i>
                        {{ $servicio->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
                        <a href="{{ route('admin.servicios.checklist', $servicio->id) }}"
                            style="background:#E8F5E9; color:#2E7D32; padding:6px 14px; border-radius:40px; text-decoration:none; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-checklist" style="font-size:12px;"></i> Checklist
                        </a>
                        <a href="{{ route('admin.servicios.edit', $servicio->id) }}"
                            style="background:#E8F5E9; color:#2E7D32; padding:6px 14px; border-radius:40px; text-decoration:none; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-edit" style="font-size:12px;"></i> Editar
                        </a>
                        @if($servicio->activo)
                        <form method="POST" action="{{ route('admin.servicios.destroy', $servicio->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Desactivar este servicio?')"
                                style="background:#FFEBEE; color:#C62828; padding:6px 14px; border-radius:40px; border:none; cursor:pointer; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                                <i class="ti ti-trash" style="font-size:12px;"></i> Desactivar
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:60px; text-align:center;">
                    <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                        <i class="ti ti-scissors-off" style="font-size:48px; color:#A1887F;"></i>
                        <p style="color:#A1887F; margin:0;">No hay servicios registrados.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection