@extends('layouts.dashboard')

@section('page-title', '🏠 Dashboard')
@section('page-subtitle', 'Bienvenido al sistema')

@section('content')

{{-- ========== VISTA CLIENTE ========== --}}
@if(Auth::user()->rol?->nombre === 'cliente')
<div style="max-width:700px; margin:0 auto; text-align:center; padding:20px 0;">
    <div style="font-size:80px;">🐾</div>
    <h2 style="font-size:28px; font-weight:800; color:#5d4037; margin-top:16px;">
        ¡Hola, {{ Auth::user()->name }}!
    </h2>
    <p style="color:#a1887f; margin-top:4px; font-size:14px;">{{ Auth::user()->email }}</p>

    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px; margin-top:32px;">
        <a href="{{ route('cliente.citas.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
            <div style="font-size:40px;">📅</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mis Citas</p>
            <p style="font-size:12px; color:#a1887f;">Ver y solicitar citas</p>
        </a>
        <a href="{{ route('cliente.mascotas.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
            <div style="font-size:40px;">🐶</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mis Mascotas</p>
            <p style="font-size:12px; color:#a1887f;">Gestionar mascotas</p>
        </a>
        <a href="{{ route('cliente.citas.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
            <div style="font-size:40px;">📋</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Historial</p>
            <p style="font-size:12px; color:#a1887f;">Servicios realizados</p>
        </a>
        <a href="{{ route('cliente.tienda.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
            <div style="font-size:40px;">🛍️</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Tienda</p>
            <p style="font-size:12px; color:#a1887f;">Productos disponibles</p>
        </a>
        <a href="{{ route('password.cambiar') }}" class="stat-card" style="text-align:center; text-decoration:none;">
            <div style="font-size:40px;">🔐</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mi cuenta</p>
            <p style="font-size:12px; color:#a1887f;">Cambiar contraseña</p>
        </a>
    </div>
</div>

{{-- ========== VISTA ADMIN ========== --}}
@elseif(Auth::user()->rol?->nombre === 'admin')

@php
    $totalClientes = \App\Models\User::whereHas('rol', fn($q) => $q->where('nombre', 'cliente'))->count();
    $citasHoy      = \App\Models\Cita::whereDate('fecha_hora_inicio', now())->whereNotIn('estado', ['cancelada'])->count();
    $totalGroomers = \App\Models\Groomer::where('activo', true)->count();
    $ingresosMes   = \App\Models\Cita::where('estado', 'completada')->whereMonth('fecha_hora_inicio', now()->month)->sum('precio_acordado');
@endphp

<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:32px; margin-bottom:8px;">👥</div>
        <p style="font-size:26px; font-weight:800; color:#ff7043;">{{ $totalClientes }}</p>
        <p style="font-size:13px; color:#a1887f;">Clientes</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:32px; margin-bottom:8px;">📅</div>
        <p style="font-size:26px; font-weight:800; color:#1565c0;">{{ $citasHoy }}</p>
        <p style="font-size:13px; color:#a1887f;">Citas hoy</p>
    </div>
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:32px; margin-bottom:8px;">✂️</div>
        <p style="font-size:26px; font-weight:800; color:#6a1b9a;">{{ $totalGroomers }}</p>
        <p style="font-size:13px; color:#a1887f;">Groomers activos</p>
    </div>
    <div class="stat-card" style="text-align:center; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white;">
        <div style="font-size:32px; margin-bottom:8px;">💰</div>
        <p style="font-size:22px; font-weight:800;">Bs. {{ number_format($ingresosMes, 2) }}</p>
        <p style="font-size:13px; opacity:0.9;">Ingresos este mes</p>
    </div>
</div>

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; margin-bottom:16px;">
    <div class="flex items-center gap-4">
        <div style="font-size:60px;">🐾</div>
        <div>
            <h2 style="font-size:22px; font-weight:800;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.9; font-size:13px;">{{ Auth::user()->email }}</p>
            <p style="opacity:0.8; font-size:12px; margin-top:4px;">Rol: <strong>Administrador</strong></p>
        </div>
    </div>
</div>
@php
    $semanaInicio = now()->startOfWeek();
    $consumoGroomers = \App\Models\Groomer::with('usuario')
        ->where('activo', true)
        ->get()
        ->map(function($g) use ($semanaInicio) {
            $g->total_insumos = \App\Models\InsumoGrooming::whereHas('ficha', function($q) use ($g) {
                $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $g->id));
            })->where('estado', '!=', 'devuelto')
              ->where('creado_en', '>=', $semanaInicio)
              ->sum('cantidad');
            return $g;
        })->sortByDesc('total_insumos');
    $limiteInsumos = 20;
@endphp

<div class="stat-card" style="margin-bottom:20px;">
    <h3 style="font-size:15px; font-weight:700; color:#5d4037; margin-bottom:16px;">📦 Consumo de insumos esta semana</h3>
    @foreach($consumoGroomers as $g)
    <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f0eb;">
        <div style="width:36px; height:36px; background:linear-gradient(135deg,#ff7043,#ff8f00); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:14px; flex-shrink:0;">
            {{ strtoupper(substr($g->nombre, 0, 1)) }}
        </div>
        <div style="flex:1;">
            <p style="font-size:13px; font-weight:600; color:#5d4037; margin:0;">{{ $g->nombre }}</p>
            <div style="background:#f5f0eb; border-radius:4px; height:6px; margin-top:4px; overflow:hidden;">
                <div style="height:100%; width:{{ min(100, ($g->total_insumos / $limiteInsumos) * 100) }}%; background:{{ $g->total_insumos >= $limiteInsumos ? 'linear-gradient(135deg,#c62828,#e53935)' : 'linear-gradient(135deg,#ff7043,#ff8f00)' }}; border-radius:4px;"></div>
            </div>
        </div>
        <span style="font-size:13px; font-weight:700; color:{{ $g->total_insumos >= $limiteInsumos ? '#c62828' : '#5d4037' }};">
            {{ $g->total_insumos }} u.
            @if($g->total_insumos >= $limiteInsumos) ⚠️ @endif
        </span>
    </div>
    @endforeach
</div>

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#ff7043,#ff8f00)...

<h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">⚡ Accesos rápidos</h3>
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
    <a href="{{ route('admin.personal.index') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); border-radius:12px; padding:14px; font-size:24px;">👥</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Personal</p>
            <p style="font-size:12px; color:#a1887f;">Groomers y recepción</p>
        </div>
    </a>
    <a href="{{ route('admin.reportes.index') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#1565c0,#1976d2); border-radius:12px; padding:14px; font-size:24px;">📊</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Reportes</p>
            <p style="font-size:12px; color:#a1887f;">Dashboard ejecutivo</p>
        </div>
    </a>
    <a href="{{ route('admin.servicios.index') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#43a047,#66bb6a); border-radius:12px; padding:14px; font-size:24px;">✂️</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Servicios</p>
            <p style="font-size:12px; color:#a1887f;">Precios y duración</p>
        </div>
    </a>
    <a href="{{ route('admin.productos.index') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#e65100,#ff7043); border-radius:12px; padding:14px; font-size:24px;">📦</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Inventario</p>
            <p style="font-size:12px; color:#a1887f;">Productos y stock</p>
        </div>
    </a>
    <a href="{{ route('admin.auditoria.index') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#5d4037,#8d6e63); border-radius:12px; padding:14px; font-size:24px;">🔍</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Auditoría</p>
            <p style="font-size:12px; color:#a1887f;">Logs del sistema</p>
        </div>
    </a>
    <a href="{{ route('2fa.setup') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#6a1b9a,#8e24aa); border-radius:12px; padding:14px; font-size:24px;">🔐</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Seguridad 2FA</p>
            <p style="font-size:12px; color:#a1887f;">Autenticación</p>
        </div>
    </a>
</div>

{{-- ========== VISTA RECEPCIÓN ========== --}}
@elseif(Auth::user()->rol?->nombre === 'recepcion')

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#1565c0,#1976d2); color:white; margin-bottom:16px;">
    <div class="flex items-center gap-4">
        <div style="font-size:60px;">📋</div>
        <div>
            <h2 style="font-size:22px; font-weight:800;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.9; font-size:13px;">{{ Auth::user()->email }}</p>
            <p style="opacity:0.8; font-size:12px; margin-top:4px;">Rol: <strong>Recepción</strong></p>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:16px;">
    <a href="{{ route('recepcion.citas.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
        <div style="font-size:40px;">📅</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Citas</p>
        <p style="font-size:12px; color:#a1887f;">Gestionar citas</p>
    </a>
    <a href="{{ route('recepcion.clientes.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
        <div style="font-size:40px;">🐶</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Clientes</p>
        <p style="font-size:12px; color:#a1887f;">Ver clientes y mascotas</p>
    </a>
    <a href="{{ route('recepcion.pagos.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
        <div style="font-size:40px;">🧾</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Pagos</p>
        <p style="font-size:12px; color:#a1887f;">Historial de pagos</p>
    </a>
    <a href="{{ route('recepcion.calendario') }}" class="stat-card" style="text-align:center; text-decoration:none;">
        <div style="font-size:40px;">📆</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Calendario</p>
        <p style="font-size:12px; color:#a1887f;">Vista semanal</p>
    </a>
    <a href="{{ route('recepcion.pagos.cierre') }}" class="sb-link">
    <span class="sb-icon">🏦</span> Cierre de caja
</a>
</div>

{{-- ========== VISTA GROOMER ========== --}}
@elseif(Auth::user()->rol?->nombre === 'groomer')

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#2e7d32,#43a047); color:white; margin-bottom:16px;">
    <div class="flex items-center gap-4">
        <div style="font-size:60px;">✂️</div>
        <div>
            <h2 style="font-size:22px; font-weight:800;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.9; font-size:13px;">{{ Auth::user()->email }}</p>
            <p style="opacity:0.8; font-size:12px; margin-top:4px;">Rol: <strong>Groomer</strong></p>
        </div>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:16px;">
    <a href="{{ route('groomer.agenda.index') }}" class="stat-card" style="text-align:center; text-decoration:none;">
        <div style="font-size:40px;">📅</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mi Agenda</p>
        <p style="font-size:12px; color:#a1887f;">Citas del día</p>
    </a>
    <a href="{{ route('password.cambiar') }}" class="stat-card" style="text-align:center; text-decoration:none;">
        <div style="font-size:40px;">🔐</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mi cuenta</p>
        <p style="font-size:12px; color:#a1887f;">Cambiar contraseña</p>
    </a>
</div>

@endif

@endsection