@extends('layouts.dashboard')

@section('page-title', '✂️ Servicios')
@section('page-subtitle', 'Gestión de servicios y precios')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:20px; font-weight:700; color:#5d4037;">Servicios</h2>
    <a href="{{ route('admin.servicios.create') }}"
        style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:14px;">
        + Nuevo Servicio
    </a>
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:linear-gradient(135deg,#ff7043,#ff8f00);">
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Servicio</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Precio base</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Duración</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Precio por tamaño</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Estado</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($servicios as $servicio)
            <tr style="border-bottom:1px solid #f5f0eb; {{ $loop->even ? 'background:#fafafa;' : '' }}">
                <td style="padding:14px 16px;">
                    <p style="font-weight:700; color:#5d4037; font-size:14px;">{{ $servicio->nombre }}</p>
                    <p style="font-size:12px; color:#a1887f;">{{ Str::limit($servicio->descripcion, 50) }}</p>
                </td>
                <td style="padding:14px 16px; font-weight:700; color:#ff7043; font-size:16px;">
                    Bs. {{ number_format($servicio->precio_base, 2) }}
                </td>
                <td style="padding:14px 16px; font-size:13px; color:#5d4037;">
                    {{ $servicio->duracion_base_minutos }} min
                </td>
                <td style="padding:14px 16px;">
                    @php $factores = $servicio->factor_tamano_raza ?? []; @endphp
                    <div style="display:flex; gap:4px; flex-wrap:wrap;">
                        @foreach(['xs','s','m','l','xl'] as $tam)
                        <span style="background:#f5f0eb; color:#5d4037; padding:2px 8px; border-radius:6px; font-size:11px; font-weight:600;">
                            {{ strtoupper($tam) }}: Bs. {{ number_format($servicio->precio_base * ($factores[$tam] ?? 1), 0) }}
                        </span>
                        @endforeach
                    </div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:{{ $servicio->activo ? '#e8f5e9' : '#ffebee' }}; color:{{ $servicio->activo ? '#2e7d32' : '#c62828' }}; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                        {{ $servicio->activo ? '● Activo' : '● Inactivo' }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:6px;">
                        <a href="{{ route('admin.servicios.edit', $servicio->id) }}"
                            style="background:#fff3e0; color:#ff7043; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600;">
                            ✏️ Editar
                        </a>
                        @if($servicio->activo)
                        <form method="POST" action="{{ route('admin.servicios.destroy', $servicio->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('¿Desactivar este servicio?')"
                                style="background:#ffebee; color:#c62828; padding:6px 12px; border-radius:6px; border:none; cursor:pointer; font-size:12px; font-weight:600; font-family:Poppins,sans-serif;">
                                Desactivar
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:48px; text-align:center; color:#a1887f;">
                    <div style="font-size:48px; margin-bottom:12px;">✂️</div>
                    No hay servicios registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection