@extends('layouts.dashboard')

@section('page-title', 'Clientes')
@section('page-subtitle', 'Lista de clientes registrados')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:16px;">
    <div style="position:relative;">
        <i class="ti ti-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:14px; color:#8A9B8A;"></i>
        <input type="text" id="buscar" placeholder="Buscar cliente..."
            onkeyup="filtrarClientes()"
            style="border:1.5px solid #e0e0e0; border-radius:40px; padding:12px 16px 12px 40px; font-size:13px; outline:none; width:280px; background:#FAFBF7; transition:all 0.2s;"
            onfocus="this.style.borderColor='#1B5E20'; this.style.background='#fff'"
            onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
    </div>
    <a href="{{ route('recepcion.clientes.create') }}" 
        style="background:#1B5E20; border:none; border-radius:40px; padding:12px 24px; font-size:13px; font-weight:600; color:#fff; text-decoration:none; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
        <i class="ti ti-user-plus" style="font-size:16px;"></i> Nuevo cliente
    </a>
</div>

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow-x:auto; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="min-width:800px; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;" id="tabla-clientes">
            <thead>
                <tr style="background:linear-gradient(135deg, #1B5E20, #0D3B0D);">
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Cliente</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Email</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Teléfono</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Mascotas</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Estado</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clientes as $cliente)
                <tr style="border-bottom:1px solid #F0F0EA; {{ $loop->even ? 'background:#FAFBF8;' : '' }}">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; background:linear-gradient(135deg, #FF7043, #F57F17); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-user" style="font-size:20px; color:#fff;"></i>
                            </div>
                            <div>
                                <p style="font-weight:700; color:#1A2E1A; font-size:14px; margin:0;">
                                    {{ $cliente->nombre }} {{ $cliente->apellido }}
                                </p>
                                <p style="font-size:11px; color:#8A9B8A; margin:2px 0 0; display:flex; align-items:center; gap:4px;">
                                    <i class="ti ti-id-badge" style="font-size:10px;"></i> CI: {{ $cliente->usuario->ci ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:13px; color:#1A2E1A; margin:0; display:flex; align-items:center; gap:6px;">
                            <i class="ti ti-mail" style="font-size:12px; color:#8A9B8A;"></i> {{ $cliente->usuario->email }}
                        </p>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:13px; color:#1A2E1A; margin:0; display:flex; align-items:center; gap:6px;">
                            <i class="ti ti-phone" style="font-size:12px; color:#8A9B8A;"></i> {{ $cliente->telefono ?? '—' }}
                        </p>
                    </td>
                    <td style="padding:16px 20px;">
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            @forelse($cliente->mascotas as $mascota)
                                <span style="background:#FFF8E1; color:#F57F17; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                                    <i class="ti ti-paw" style="font-size:10px;"></i> {{ $mascota->nombre }}
                                </span>
                            @empty
                                <span style="font-size:11px; color:#8A9B8A; display:inline-flex; align-items:center; gap:4px;">
                                    <i class="ti ti-dog" style="font-size:11px;"></i> Sin mascotas
                                </span>
                            @endforelse
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        <span style="background:{{ $cliente->usuario->activo ? '#E8F5E9' : '#FFEBEE' }}; color:{{ $cliente->usuario->activo ? '#2E7D32' : '#C62828' }}; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti {{ $cliente->usuario->activo ? 'ti-circle-filled' : 'ti-circle-x' }}" style="font-size:8px;"></i> 
                            {{ $cliente->usuario->activo ? 'Activo' : 'Inactivo' }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;">
                        <a href="{{ route('recepcion.clientes.show', $cliente->id) }}" 
                            style="background:#E3F2FD; color:#1565C0; padding:8px 16px; border-radius:10px; text-decoration:none; font-size:12px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-eye" style="font-size:13px;"></i> Ver detalle
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:56px 24px; text-align:center;">
                        <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="ti ti-users" style="font-size:28px; color:#8A9B8A;"></i>
                        </div>
                        <p style="color:#8A9B8A; font-size:14px; margin:0;">No hay clientes registrados.</p>
                        <a href="{{ route('recepcion.clientes.create') }}" style="display:inline-flex; align-items:center; gap:6px; margin-top:12px; color:#1B5E20; font-size:13px; font-weight:600; text-decoration:none;">
                            <i class="ti ti-user-plus"></i> Crear primer cliente
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function filtrarClientes() {
    const buscar = document.getElementById('buscar').value.toLowerCase();
    const filas  = document.querySelectorAll('#tabla-clientes tbody tr');
    filas.forEach(fila => {
        const texto = fila.textContent.toLowerCase();
        fila.style.display = texto.includes(buscar) ? '' : 'none';
    });
}
</script>

@endsection