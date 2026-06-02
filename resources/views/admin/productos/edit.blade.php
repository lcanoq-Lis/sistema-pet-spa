@extends('layouts.dashboard')

@section('page-title', 'Editar Producto')
@section('page-subtitle', 'Actualiza la información del producto')

@section('content')
<div style="max-width:700px; margin:0 auto;">
    <div class="stat-card" style="border-radius:24px; padding:28px;">

        @if($errors->any())
            <div style="background:#FFF3E0; color:#E65100; border-left:4px solid #FF7043; padding:14px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:10px;">
                <i class="ti ti-alert-circle" style="font-size:18px;"></i>
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.productos.update', $producto->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-tag"></i> Nombre *
                    </label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-barcode"></i> SKU *
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $producto->sku) }}"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-folder"></i> Categoría
                    </label>
                    <select name="categoria_id"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; background:white;">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-coin"></i> Precio base (Bs.) *
                    </label>
                    <input type="number" name="precio_base" value="{{ old('precio_base', $producto->precio_base) }}" step="0.01" min="0"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-box"></i> Stock actual *
                    </label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" min="0"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-chart-line"></i> Stock mínimo *
                    </label>
                    <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo) }}" min="0"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-notes"></i> Descripción
                    </label>
                    <textarea name="descripcion" rows="3"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; resize:vertical;">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-photo"></i> URL de imagen
                    </label>
                    <input type="text" name="imagen_url" value="{{ old('imagen_url', $producto->imagen_url) }}"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;">
                </div>

            </div>

            <div style="margin-bottom:28px;">
                <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <input type="checkbox" name="activo" {{ $producto->activo ? 'checked' : '' }}
                        style="width:18px; height:18px; accent-color:#2E7D32;">
                    <span style="font-size:13px; font-weight:600; color:#5D4037; display:flex; align-items:center; gap:6px;">
                        <i class="ti ti-circle-check"></i> Producto activo
                    </span>
                </label>
            </div>

            <div style="display:flex; gap:14px;">
                <a href="{{ route('admin.productos.index') }}"
                    style="flex:1; text-align:center; background:#F5F0EB; color:#8D6E63; font-weight:600; padding:14px; border-radius:40px; text-decoration:none; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-arrow-left"></i> Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:700; padding:14px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-device-floppy"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection