@extends('layouts.dashboard')

@section('page-title', 'Inventario')
@section('page-subtitle', 'Gestión de productos y stock')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; color:#2E7D32; border-left:4px solid #43A047; padding:14px 18px; border-radius:12px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="font-size:18px;"></i> {{ session('status') }}
    </div>
@endif

{{-- Alerta bajo stock --}}
@if($bajoStock->isNotEmpty())
<div style="background:#FFEBEE; color:#C62828; border-left:4px solid #EF5350; padding:14px 18px; border-radius:12px; font-size:13px; margin-bottom:20px; display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
    <i class="ti ti-alert-triangle" style="font-size:18px;"></i>
    <strong>{{ $bajoStock->count() }} producto(s)</strong> con stock bajo:
    {{ $bajoStock->pluck('nombre')->join(', ') }}
</div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; flex-wrap:wrap; gap:12px;">
    <h2 style="font-size:18px; font-weight:700; color:#5D4037; display:flex; align-items:center; gap:8px;">
        <i class="ti ti-package" style="font-size:20px; color:#2E7D32;"></i> Productos
    </h2>
    <a href="{{ route('admin.productos.create') }}"
        style="background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:600; padding:10px 20px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:8px; transition:all 0.2s;">
        <i class="ti ti-plus" style="font-size:16px;"></i> Nuevo Producto
    </a>
</div>

<div class="stat-card" style="padding:0; overflow-x:auto; border-radius:20px;">
    <table style="width:100%; border-collapse:collapse; min-width:700px;">
        <thead>
            <tr style="background:linear-gradient(135deg,#2E7D32,#43A047);">
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-tag" style="font-size:14px;"></i> Producto</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-barcode" style="font-size:14px;"></i> SKU</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-folder" style="font-size:14px;"></i> Categoría</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-coin" style="font-size:14px;"></i> Precio</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-box" style="font-size:14px;"></i> Stock</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-status-change" style="font-size:14px;"></i> Estado</th>
                <th style="padding:14px 16px; color:white; font-size:12px; text-align:left;"><i class="ti ti-settings" style="font-size:14px;"></i> Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
            <tr style="border-bottom:1px solid #F5F0EB; background:{{ $loop->even ? '#FAFAFA' : 'white' }}; transition:background 0.2s;">
                <td style="padding:14px 16px;">
                    <p style="font-weight:700; color:#5D4037; font-size:14px; margin:0 0 4px; display:flex; align-items:center; gap:6px;">
                        <i class="ti ti-paw" style="color:#2E7D32; font-size:14px;"></i> {{ $producto->nombre }}
                    </p>
                    <p style="font-size:11px; color:#A1887F; margin:0;">{{ Str::limit($producto->descripcion, 40) }}</p>
                </td>
                <td style="padding:14px 16px; font-size:12px; color:#5D4037; font-family:monospace;">{{ $producto->sku }}</td>
                <td style="padding:14px 16px; font-size:12px; color:#A1887F;">{{ $producto->categoria?->nombre ?? '—' }}</td>
                <td style="padding:14px 16px; font-weight:700; color:#2E7D32;">Bs. {{ number_format($producto->precio_base, 2) }}</td>
                <td style="padding:14px 16px;">
                    <span style="font-weight:700; font-size:13px; color:{{ $producto->bajoPorStock() ? '#C62828' : '#2E7D32' }};">
                        {{ $producto->stock }}
                    </span>
                    <span style="font-size:10px; color:#A1887F;">/ mín {{ $producto->stock_minimo }}</span>
                </td>
                <td style="padding:14px 16px;">
                    <span style="background:{{ $producto->activo ? '#E8F5E9' : '#FFEBEE' }}; color:{{ $producto->activo ? '#2E7D32' : '#C62828' }}; padding:4px 12px; border-radius:40px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px;">
                        <i class="ti {{ $producto->activo ? 'ti-circle-check' : 'ti-circle-x' }}" style="font-size:10px;"></i>
                        {{ $producto->activo ? 'Activo' : 'Inactivo' }}
                    </span>
                </td>
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:8px;">
                        <a href="{{ route('admin.productos.edit', $producto->id) }}"
                            style="background:#E8F5E9; color:#2E7D32; padding:6px 14px; border-radius:40px; text-decoration:none; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                            <i class="ti ti-edit" style="font-size:12px;"></i> Editar
                        </a>
                        @if($producto->activo)
                        <form method="POST" action="{{ route('admin.productos.destroy', $producto->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Desactivar este producto?')"
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
                <td colspan="7" style="padding:60px; text-align:center;">
                    <div style="display:flex; flex-direction:column; align-items:center; gap:12px;">
                        <i class="ti ti-package-off" style="font-size:48px; color:#A1887F;"></i>
                        <p style="color:#A1887F; margin:0;">No hay productos registrados.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection