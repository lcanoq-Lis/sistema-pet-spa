@extends('layouts.dashboard')

@section('page-title', '🛒 Mi Carrito')
@section('page-subtitle', 'Revisa y confirma tu pedido')

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

@if($carrito->items->isEmpty())
    <div class="stat-card" style="text-align:center; padding:64px;">
        <div style="font-size:72px;">🛒</div>
        <h3 style="font-size:20px; font-weight:700; color:var(--text-primary); margin-top:16px;">Tu carrito está vacío</h3>
        <p style="color:var(--text-muted); margin-top:8px;">Agrega productos desde la tienda</p>
        <a href="{{ route('cliente.tienda.index') }}"
            style="display:inline-block; margin-top:24px; background:var(--brand); color:white; font-weight:600; padding:12px 28px; border-radius:10px; text-decoration:none;">
            Ir a la tienda
        </a>
    </div>
@else
<div style="display:grid; grid-template-columns:1fr 340px; gap:24px; align-items:start;">

    {{-- Productos --}}
    <div class="stat-card" style="padding:0; overflow:hidden;">
        <div style="padding:20px 24px; border-bottom:1px solid var(--border);">
            <h2 style="font-size:16px; font-weight:700; color:var(--text-primary);">Productos ({{ $carrito->items->count() }})</h2>
        </div>

        @foreach($carrito->items as $item)
        <div style="display:flex; align-items:center; gap:16px; padding:16px 24px; border-bottom:1px solid var(--border);">
            {{-- Imagen --}}
            <div style="width:64px; height:64px; background:var(--brand-light); border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden;">
                @if($item->producto->imagen_url)
                    <img src="{{ $item->producto->imagen_url }}" style="width:100%; height:100%; object-fit:cover;">
                @else
                    <span style="font-size:28px;">📦</span>
                @endif
            </div>

            {{-- Info --}}
            <div style="flex:1;">
                <div style="font-weight:700; color:var(--text-primary); font-size:15px;">{{ $item->producto->nombre }}</div>
                <div style="color:var(--text-muted); font-size:13px; margin-top:2px;">Bs. {{ number_format($item->precio_unitario, 2) }} c/u</div>
            </div>

            {{-- Cantidad --}}
            <form method="POST" action="{{ route('cliente.carrito.actualizar', $item->id) }}" style="display:flex; align-items:center; gap:8px;">
                @csrf @method('PATCH')
                <input type="number" name="cantidad" value="{{ $item->cantidad }}" min="1" max="{{ $item->producto->stock }}"
                    style="width:64px; border:2px solid var(--border); border-radius:8px; padding:6px 8px; text-align:center; font-weight:600; font-size:14px; outline:none;"
                    onchange="this.form.submit()">
            </form>

            {{-- Subtotal --}}
            <div style="font-weight:800; color:var(--brand); font-size:16px; min-width:80px; text-align:right;">
                Bs. {{ number_format($item->subtotal(), 2) }}
            </div>

            {{-- Eliminar --}}
            <form method="POST" action="{{ route('cliente.carrito.eliminar', $item->id) }}">
                @csrf @method('DELETE')
                <button type="submit" style="background:none; border:none; cursor:pointer; color:#ef5350; font-size:18px; padding:4px 8px;" title="Eliminar">🗑️</button>
            </form>
        </div>
        @endforeach
    </div>

    {{-- Resumen --}}
    <div style="display:flex; flex-direction:column; gap:16px;">

        {{-- Cupón --}}
        <div class="stat-card">
            <h3 style="font-size:14px; font-weight:700; color:var(--text-primary); margin-bottom:12px;">🎫 Cupón de descuento</h3>

            @if($carrito->cupon)
                <div style="background:var(--brand-light); border-radius:8px; padding:10px 14px; display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <div style="font-weight:700; color:var(--brand);">{{ $carrito->cupon->codigo }}</div>
                        <div style="font-size:12px; color:var(--text-muted);">-Bs. {{ number_format($carrito->descuento, 2) }}</div>
                    </div>
                    <form method="POST" action="{{ route('cliente.carrito.cupon.quitar') }}">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none; border:none; cursor:pointer; color:#ef5350; font-weight:600; font-size:13px;">Quitar</button>
                    </form>
                </div>
            @else
                <form method="POST" action="{{ route('cliente.carrito.cupon') }}" style="display:flex; gap:8px;">
                    @csrf
                    <input type="text" name="codigo" placeholder="Código de cupón"
                        style="flex:1; border:2px solid var(--border); border-radius:8px; padding:8px 12px; font-size:13px; outline:none; text-transform:uppercase;"
                        required>
                    <button type="submit"
                        style="background:var(--brand); color:white; font-weight:600; padding:8px 14px; border-radius:8px; border:none; cursor:pointer; font-size:13px;">
                        Aplicar
                    </button>
                </form>
            @endif
        </div>

        {{-- Total --}}
        <div class="stat-card">
            <h3 style="font-size:14px; font-weight:700; color:var(--text-primary); margin-bottom:16px;">Resumen del pedido</h3>

            <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                <span style="color:var(--text-secondary);">Subtotal</span>
                <span style="font-weight:600;">Bs. {{ number_format($carrito->subtotal(), 2) }}</span>
            </div>

            @if($carrito->descuento > 0)
            <div style="display:flex; justify-content:space-between; margin-bottom:10px; color:#2e7d32;">
                <span>Descuento</span>
                <span style="font-weight:600;">-Bs. {{ number_format($carrito->descuento, 2) }}</span>
            </div>
            @endif

            <div style="border-top:2px solid var(--border); padding-top:12px; display:flex; justify-content:space-between; align-items:center;">
                <span style="font-weight:700; font-size:16px;">Total</span>
                <span style="font-weight:800; font-size:22px; color:var(--brand);">Bs. {{ number_format($carrito->total(), 2) }}</span>
            </div>

            <form method="POST" action="{{ route('cliente.carrito.confirmar') }}" style="margin-top:16px;">
                @csrf
                <button type="submit"
                    style="width:100%; background:linear-gradient(135deg,#25d366,#128c7e); color:white; font-weight:700; padding:14px; border-radius:10px; border:none; cursor:pointer; font-size:15px;">
                    📲 Confirmar por WhatsApp
                </button>
            </form>

            <a href="{{ route('cliente.tienda.index') }}"
                style="display:block; text-align:center; margin-top:10px; color:var(--text-muted); font-size:13px; text-decoration:none;">
                ← Seguir comprando
            </a>
        </div>
    </div>

</div>
@endif

@endsection
