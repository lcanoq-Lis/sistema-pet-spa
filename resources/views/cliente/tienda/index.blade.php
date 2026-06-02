@extends('layouts.dashboard')

@section('page-title', 'Tienda')
@section('page-subtitle', 'Productos disponibles para tu mascota')

@section('content')

{{-- Filtros --}}
<div style="margin-bottom:28px;">
    <form method="GET" action="{{ route('cliente.tienda.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center;">
        <div style="position:relative; flex:1; min-width:200px;">
            <i class="ti ti-search" style="position:absolute; left:14px; top:50%; transform:translateY(-50%); font-size:14px; color:#8A9B8A;"></i>
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                placeholder="Buscar producto..."
                style="width:100%; border:1.5px solid #e0e0e0; border-radius:40px; padding:12px 16px 12px 42px; font-size:13px; outline:none; background:#FAFBF7; transition:all 0.2s;"
                onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
                onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
        </div>

        <select name="categoria"
            style="border:1.5px solid #e0e0e0; border-radius:40px; padding:12px 20px; font-size:13px; outline:none; background:#FAFBF7; cursor:pointer; transition:all 0.2s;"
            onfocus="this.style.borderColor='#FF7043'; this.style.background='#fff'"
            onblur="this.style.borderColor='#e0e0e0'; this.style.background='#FAFBF7'">
            <option value="">Todas las categorías</option>
            @foreach($categorias as $cat)
                <option value="{{ $cat->id }}" {{ request('categoria') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->nombre }}
                </option>
            @endforeach
        </select>

        <button type="submit"
            style="background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:12px 28px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
            <i class="ti ti-filter" style="font-size:14px;"></i> Filtrar
        </button>

        @if(request('buscar') || request('categoria'))
        <a href="{{ route('cliente.tienda.index') }}"
            style="background:#fff; border:1.5px solid #e0e0e0; color:#5D6E5D; font-weight:600; padding:12px 24px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
            <i class="ti ti-x" style="font-size:14px;"></i> Limpiar
        </a>
        @endif
    </form>
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
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden; transition:box-shadow 0.2s; display:flex; flex-direction:column;">
            
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
                <div>
                    <span style="font-size:22px; font-weight:800; color:#FF7043;">
                        Bs. {{ number_format($producto->precio_base, 2) }}
                    </span>
                    @if($producto->precio_oferta)
                    <span style="font-size:11px; color:#8A9B8A; text-decoration:line-through; display:block;">
                        Bs. {{ number_format($producto->precio_oferta, 2) }}
                    </span>
                    @endif
                </div>
                <span style="font-size:11px; font-weight:700; padding:4px 12px; border-radius:30px; background:{{ $producto->stock > 0 ? '#E8F5E9' : '#FFEBEE' }}; color:{{ $producto->stock > 0 ? '#2E7D32' : '#C62828' }}; display:inline-flex; align-items:center; gap:4px;">
                    <i class="ti {{ $producto->stock > 0 ? 'ti-circle-check' : 'ti-circle-x' }}" style="font-size:10px;"></i>
                    {{ $producto->stock > 0 ? 'Disponible' : 'Sin stock' }}
                </span>
            </div>

            {{-- Botón pedido WhatsApp --}}
            @if($producto->stock > 0)
            <div style="padding:0 20px 20px 20px;">
                <a href="https://wa.me/59174260228?text=Hola!+Me+interesa+el+producto:+{{ urlencode($producto->nombre) }}+—+Precio:+Bs.+{{ $producto->precio_base }}"
                    target="_blank"
                    style="display:flex; align-items:center; justify-content:center; gap:8px; background:linear-gradient(135deg, #25D366, #128C7E); color:#fff; font-weight:700; padding:12px; border-radius:40px; text-decoration:none; font-size:13px; transition:all 0.2s;">
                    <i class="ti ti-brand-whatsapp" style="font-size:18px;"></i> Pedir por WhatsApp
                </a>
            </div>
            @endif
        </div>
        @endforeach
    </div>

    {{-- Paginación (si existe) --}}
    @if(method_exists($productos, 'links'))
    <div style="margin-top:32px;">
        {{ $productos->links() }}
    </div>
    @endif
@endif

@endsection