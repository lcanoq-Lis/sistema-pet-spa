@extends('layouts.dashboard')

@section('page-title', '🛍️ Tienda')
@section('page-subtitle', 'Productos disponibles para tu mascota')

@section('content')

{{-- Filtros --}}
<div style="display:flex; gap:12px; margin-bottom:24px; flex-wrap:wrap; align-items:center;">
    <form method="GET" action="{{ route('cliente.tienda.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; flex:1;">
        <input type="text" name="buscar" value="{{ request('buscar') }}"
            placeholder="🔍 Buscar producto..."
            style="border:2px solid #d7ccc8; border-radius:10px; padding:8px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; flex:1; min-width:200px;">

        <select name="categoria"
            style="border:2px solid #d7ccc8; border-radius:10px; padding:8px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:8px 20px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
            Filtrar
        </button>

        @if(request('buscar') || request('categoria'))
        <a href="{{ route('cliente.tienda.index') }}"
            style="background:#f5f0eb; color:#8d6e63; font-weight:600; padding:8px 16px; border-radius:10px; text-decoration:none; font-size:14px;">
            Limpiar
        </a>
        @endif
    </form>
</div>

@if($productos->isEmpty())
    <div class="stat-card" style="text-align:center; padding:48px;">
        <div style="font-size:64px;">🛍️</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-top:16px;">No hay productos disponibles</h3>
    </div>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:16px;">
        @foreach($productos as $producto)
        <div class="stat-card" style="display:flex; flex-direction:column;">

            {{-- Imagen --}}
            <div style="background:#f5f0eb; border-radius:12px; height:160px; display:flex; align-items:center; justify-content:center; margin-bottom:16px; overflow:hidden;">
                @if($producto->imagen_url)
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}"
                        style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
                @else
                    <span style="font-size:64px;">📦</span>
                @endif
            </div>

            {{-- Info --}}
            <div style="flex:1;">
                @if($producto->categoria)
                <span style="background:#fff3e0; color:#e65100; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">
                    {{ $producto->categoria->nombre }}
                </span>
                @endif
                <h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-top:8px;">{{ $producto->nombre }}</h3>
                @if($producto->descripcion)
                <p style="font-size:13px; color:#a1887f; margin-top:4px;">{{ Str::limit($producto->descripcion, 60) }}</p>
                @endif
            </div>

            {{-- Precio y stock --}}
            <div style="display:flex; justify-content:space-between; align-items:center; margin-top:16px; padding-top:12px; border-top:1px solid #f5f0eb;">
                <span style="font-size:20px; font-weight:800; color:#ff7043;">
                    Bs. {{ number_format($producto->precio_base, 2) }}
                </span>
                <span style="font-size:12px; color:{{ $producto->stock > 0 ? '#2e7d32' : '#c62828' }}; font-weight:600;">
                    {{ $producto->stock > 0 ? '✅ Disponible' : '❌ Sin stock' }}
                </span>
            </div>

            {{-- Botón pedido WhatsApp --}}
            @if($producto->stock > 0)
            <a href="https://wa.me/59174260228?text=Hola!+Me+interesa+el+producto:+{{ urlencode($producto->nombre) }}+—+Precio:+Bs.+{{ $producto->precio_base }}"
                target="_blank"
                style="display:block; text-align:center; background:linear-gradient(135deg,#25d366,#128c7e); color:white; font-weight:600; padding:10px; border-radius:10px; text-decoration:none; font-size:14px; margin-top:12px;">
                🛒 Pedir por WhatsApp
            </a>
            @endif
        </div>
        @endforeach
    </div>
@endif

@endsection