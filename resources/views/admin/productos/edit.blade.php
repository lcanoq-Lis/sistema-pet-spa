@extends('layouts.dashboard')

@section('page-title', '✏️ Editar Producto')
@section('page-subtitle', 'Actualiza la información del producto')

@section('content')
<div style="max-width:600px; margin:0 auto;">
    <div class="stat-card">

        @if($errors->any())
            <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.productos.update', $producto->id) }}">
            @csrf
            @method('PUT')

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $producto->nombre) }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">SKU *</label>
                    <input type="text" name="sku" value="{{ old('sku', $producto->sku) }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Categoría</label>
                    <select name="categoria_id"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ $producto->categoria_id == $cat->id ? 'selected' : '' }}>
                                {{ $cat->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Precio base (Bs.) *</label>
                    <input type="number" name="precio_base" value="{{ old('precio_base', $producto->precio_base) }}" step="0.01" min="0"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Stock actual *</label>
                    <input type="number" name="stock" value="{{ old('stock', $producto->stock) }}" min="0"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Stock mínimo *</label>
                    <input type="number" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo) }}" min="0"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div style="grid-column:span 2;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">URL de imagen</label>
                    <input type="text" name="imagen_url" value="{{ old('imagen_url', $producto->imagen_url) }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                </div>

            </div>

            <div style="display:flex; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.productos.index') }}"
                    style="flex:1; text-align:center; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
                    ← Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Guardar cambios ✓
                </button>
            </div>
        </form>
    </div>
</div>
@endsection