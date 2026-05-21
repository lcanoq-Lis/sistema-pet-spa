@extends('layouts.dashboard')

@section('page-title', '👥 Clientes')
@section('page-subtitle', 'Lista de clientes registrados')

@section('content')

<div style="margin-bottom:24px;">
    <input type="text" id="buscar" placeholder="🔍 Buscar cliente..."
        onkeyup="filtrarClientes()"
        style="border:2px solid #d7ccc8; border-radius:10px; padding:10px 16px; font-size:14px; outline:none; font-family:Poppins,sans-serif; width:300px;">
</div>

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;" id="tabla-clientes">
        <thead>
            <tr style="background:linear-gradient(135deg,#ff7043,#ff8f00);">
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Cliente</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Email</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Teléfono</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Mascotas</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Estado</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $cliente)
            <tr style="border-bottom:1px solid #f5f0eb; {{ $loop->even ? 'background:#fafafa;' : '' }}">
                <td style="padding:14px 16px;">
                    <p style="font-weight:700; color:#5d4037; font-size:14px;">
                        {{ $cliente->nombre }} {{ $cliente->apellido }}
                    </p>
                    <p style="font-size:12px; color:#a1887f;">CI: {{ $cliente->usuario->ci ?? '—' }}</p>
                </td>
                <td style="padding:14px 16px; font-size:13px; color:#5d4037;">
                    {{ $cliente->usuario->email }}
                </td>
                <td style="padding:14px 16px; font-size:13px; color:#5d4037;">
                    {{ $cliente->telefono ?? '—' }}
                </td>
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:4px; flex-wrap:wrap;">
                        @forelse($cliente->mascotas as $mascota)
                            <span style="background:#fff3e0; color:#ff7043; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">
                                @if($mascota->especie === 'perro') 🐶
                                @elseif($mascota->especie === 'gato') 🐱
                                @else 🐾
                                @endif
                                {{ $mascota->nombre }}
                            </span>
                        @empty
                            <span style="font-size:12px; color:#a1887f;">Sin mascotas</span>
                        @endforelse
                    </div>
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:{{ $cliente->usuario->activo ? '#e8f5e9' : '#ffebee' }}; color:{{ $cliente->usuario->activo ? '#2e7d32' : '#c62828' }}; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                        {{ $cliente->usuario->activo ? '● Activo' : '● Inactivo' }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <a href="{{ route('recepcion.clientes.show', $cliente->id) }}"
                        style="background:#e3f2fd; color:#1565c0; padding:6px 12px; border-radius:6px; text-decoration:none; font-size:12px; font-weight:600;">
                        👁️ Ver detalle
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:48px; text-align:center; color:#a1887f;">
                    <div style="font-size:48px; margin-bottom:12px;">👥</div>
                    No hay clientes registrados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function filtrarClientes() {
    const buscar = document.getElementById('buscar').value.toLowerCase();
    const filas  = document.querySelectorAll('#tabla-clientes tbody tr');
    filas.forEach(fila => {
        fila.style.display = fila.textContent.toLowerCase().includes(buscar) ? '' : 'none';
    });
}
</script>

@endsection