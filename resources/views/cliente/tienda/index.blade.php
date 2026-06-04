@extends('layouts.dashboard')

@section('page-title', 'Tienda')
@section('page-subtitle', 'Productos disponibles para tu mascota')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; border:1px solid #a5d6a7; border-radius:10px; padding:12px 16px; margin-bottom:20px; color:#2e7d32; font-weight:600;">
        {{ session('status') }}
    </div>
@endif
@if(session('error'))
    <div style="background:#ffebee; border:1px solid #ef9a9a; border-radius:10px; padding:12px 16px; margin-bottom:20px; color:#c62828; font-weight:600;">
        {{ session('error') }}
    </div>
@endif

{{-- Filtros + Botón Carrito --}}
<div style="margin-bottom:28px;">
    <div style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; justify-content:space-between;">
        <form method="GET" action="{{ route('cliente.tienda.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; flex:1;">
            <div style="position:relative; flex:1; min-width:200px;">
                <i class="ti ti-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:14px; color:#8A9B8A;"></i>
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="Buscar producto..."
                    style="width:100%; border:1.5px solid #e0e0e0; border-radius:40px; padding:12px 16px 12px 42px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                    onfocus="this.style.borderColor='#2E7D32'; this.style.background='#fff'"
                    onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            </div>

            <select name="categoria"
                style="border:1.5px solid #e0e0e0; border-radius:40px; padding:12px 20px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer;">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $cat)
                    <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->nombre }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                style="background:linear-gradient(135deg, #2E7D32, #1B5E20); color:#fff; font-weight:600; padding:12px 28px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                <i class="ti ti-filter" style="font-size:14px;"></i> Filtrar
            </button>

            @if(request('buscar') || request('categoria'))
            <a href="{{ route('cliente.tienda.index') }}"
                style="background:#fff; border:1.5px solid #e0e0e0; color:#5D6E5D; font-weight:600; padding:12px 24px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                <i class="ti ti-x" style="font-size:14px;"></i> Limpiar
            </a>
            @endif
        </form>

        {{-- Botón carrito con contador --}}
        @php $totalItems = \App\Models\Carrito::where('user_id', auth()->id())->first()?->items()->sum('cantidad') ?? 0; @endphp
        <a href="{{ route('cliente.carrito.index') }}"
            style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg, #2E7D32, #1B5E20); color:#fff; font-weight:700; padding:12px 24px; border-radius:40px; text-decoration:none; font-size:13px; position:relative; flex-shrink:0;">
            <i class="ti ti-shopping-cart" style="font-size:18px;"></i> Mi Carrito
            @if($totalItems > 0)
            <span style="background:#FF7043; color:white; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:800;">
                {{ $totalItems }}
            </span>
            @endif
        </a>
    </div>
</div>

@if($productos->isEmpty())
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:56px 24px;">
        <div style="width:72px; height:72px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-package" style="font-size:32px; color:#8A9B8A;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A2E1A;">No hay productos disponibles</h3>
        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Pronto tendremos nuevos productos para ti.</p>
    </div>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:24px;">
        @foreach($productos as $producto)
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden; display:flex; flex-direction:column;">

            {{-- Imagen --}}
            <div style="background:linear-gradient(135deg, #F5F5F0, #EDEDE5); height:180px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                @if($producto->imagen_url)
                    <img src="{{ $producto->imagen_url }}" alt="{{ $producto->nombre }}"
                        style="width:100%; height:100%; object-fit:cover;">
                @else
                    <div style="width:80px; height:80px; background:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center;">
                        <i class="ti ti-package" style="font-size:40px; color:#8A9B8A;"></i>
                    </div>
                @endif
            </div>

            {{-- Info --}}
            <div style="padding:20px 20px 0 20px; flex:1;">
                @if($producto->categoria)
                <span style="background:#FFF8E1; color:#F57F17; padding:4px 12px; border-radius:30px; font-size:10px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                    <i class="ti ti-tag" style="font-size:10px;"></i> {{ $producto->categoria->nombre }}
                </span>
                @endif
                <h3 style="font-size:16px; font-weight:800; color:#1A2E1A; margin-top:10px;">{{ $producto->nombre }}</h3>
                @if($producto->descripcion)
                <p style="font-size:12px; color:#8A9B8A; margin-top:6px; line-height:1.4;">{{ Str::limit($producto->descripcion, 70) }}</p>
                @endif
            </div>

            {{-- Precio y stock --}}
            <div style="padding:16px 20px; border-top:1px solid #F0F0EA; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-size:22px; font-weight:800; color:#2E7D32;">
                    Bs. {{ number_format($producto->precio_base, 2) }}
                </span>
                <span style="font-size:11px; font-weight:700; padding:4px 12px; border-radius:30px; background:{{ $producto->stock > 0 ? '#E8F5E9' : '#FFEBEE' }}; color:{{ $producto->stock > 0 ? '#2E7D32' : '#C62828' }}; display:inline-flex; align-items:center; gap:4px;">
                    <i class="ti {{ $producto->stock > 0 ? 'ti-circle-check' : 'ti-circle-x' }}" style="font-size:10px;"></i>
                    {{ $producto->stock > 0 ? 'Disponible' : 'Sin stock' }}
                </span>
            </div>

            {{-- Botón agregar al carrito --}}
            @if($producto->stock > 0)
            <div style="padding:0 20px 20px 20px;">
                <form method="POST" action="{{ route('cliente.carrito.agregar') }}" style="display:flex; gap:8px;">
                    @csrf
                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                    <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}"
                        style="width:60px; border:1.5px solid #e0e0e0; border-radius:40px; padding:10px 8px; text-align:center; font-weight:700; font-size:14px; outline:none; background:#FAFBF7;">
                    <button type="submit"
                        style="flex:1; display:flex; align-items:center; justify-content:center; gap:8px; background:linear-gradient(135deg, #2E7D32, #1B5E20); color:#fff; font-weight:700; padding:12px; border-radius:40px; border:none; cursor:pointer; font-size:13px;">
                        <i class="ti ti-shopping-cart-plus" style="font-size:16px;"></i> Agregar
                    </button>
                </form>
            </div>
            @else
            <div style="padding:0 20px 20px 20px;">
                <div style="text-align:center; color:#C62828; font-weight:600; font-size:13px; padding:12px; background:#FFEBEE; border-radius:40px;">
                    Sin stock
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    @if(method_exists($productos, 'links'))
    <div style="margin-top:32px;">
        {{ $productos->links() }}
    </div>
    @endif
@endif

@endsection
