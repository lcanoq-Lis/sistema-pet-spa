@extends('layouts.dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen general del sistema')

@section('content')

{{-- ===== CLIENTE ===== --}}
@if(Auth::user()->rol?->nombre === 'cliente')
<div style="max-width:680px;">
    <div style="background:linear-gradient(135deg,#1B5E20,#2E7D32); border-radius:16px; padding:28px; margin-bottom:24px; color:#fff; display:flex; align-items:center; gap:20px;">
        <div style="font-size:52px; line-height:1;">🐾</div>
        <div>
            <h2 style="font-size:20px; font-weight:700; margin-bottom:4px;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.8; font-size:13px;">{{ Auth::user()->email }}</p>
        </div>
    </div>
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
        @foreach([
            ['route'=>'cliente.citas.index',   'icon'=>'📅','label'=>'Mis Citas',   'sub'=>'Ver y solicitar'],
            ['route'=>'cliente.mascotas.index','icon'=>'🐶','label'=>'Mascotas',    'sub'=>'Gestionar perfiles'],
            ['route'=>'cliente.historial',     'icon'=>'📋','label'=>'Historial',   'sub'=>'Servicios pasados'],
            ['route'=>'tienda.index',          'icon'=>'🛍️','label'=>'Tienda',      'sub'=>'Ver productos'],
            ['route'=>'password.cambiar',      'icon'=>'🔐','label'=>'Mi cuenta',   'sub'=>'Cambiar contraseña'],
        ] as $item)
        <a href="{{ route($item['route']) }}" class="stat-card" style="text-decoration:none; text-align:center; padding:20px 14px;">
            <div style="font-size:28px; margin-bottom:8px;">{{ $item['icon'] }}</div>
            <p style="font-size:13px; font-weight:700; color:#1A2E1A; margin-bottom:2px;">{{ $item['label'] }}</p>
            <p style="font-size:11px; color:#6B8F6B;">{{ $item['sub'] }}</p>
        </a>
        @endforeach
    </div>
</div>

{{-- ===== ADMIN ===== --}}
@elseif(Auth::user()->rol?->nombre === 'admin')
@php
    $kpis = [
        ['val'=> \App\Models\User::whereHas('rol',fn($q)=>$q->where('nombre','cliente'))->count(), 'label'=>'Clientes', 'icon'=>'👥', 'color'=>'#1B5E20'],
        ['val'=> \App\Models\Cita::whereDate('fecha_hora_inicio',now())->whereNotIn('estado',['cancelada'])->count(), 'label'=>'Citas hoy', 'icon'=>'📅', 'color'=>'#1565C0'],
        ['val'=> \App\Models\Groomer::where('activo',true)->count(), 'label'=>'Groomers', 'icon'=>'✂️', 'color'=>'#6A1B9A'],
        ['val'=> 'Bs. '.\App\Models\Cita::where('estado','completada')->whereMonth('fecha_hora_inicio',now()->month)->sum('precio_acordado'), 'label'=>'Ingresos mes', 'icon'=>'💰', 'color'=>'#E65100'],
    ];
@endphp
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    @foreach($kpis as $k)
    <div class="stat-card" style="text-align:center;">
        <div style="font-size:28px; margin-bottom:10px;">{{ $k['icon'] }}</div>
        <p style="font-size:22px; font-weight:800; color:{{ $k['color'] }}; margin-bottom:4px;">{{ $k['val'] }}</p>
        <p style="font-size:12px; color:#6B8F6B;">{{ $k['label'] }}</p>
    </div>
    @endforeach
</div>

<h3 style="font-size:14px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:14px;">Accesos rápidos</h3>
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px;">
    @foreach([
        ['route'=>'admin.personal.index',    'icon'=>'👥','label'=>'Personal',      'sub'=>'Groomers y recepción',  'color'=>'#E8F5E9','ic'=>'#2E7D32'],
        ['route'=>'admin.reportes.index',    'icon'=>'📊','label'=>'Reportes',      'sub'=>'KPIs del negocio',      'color'=>'#E3F2FD','ic'=>'#1565C0'],
        ['route'=>'admin.servicios.index',   'icon'=>'✂️','label'=>'Servicios',     'sub'=>'Precios y duración',    'color'=>'#F3E5F5','ic'=>'#6A1B9A'],
        ['route'=>'admin.productos.index',   'icon'=>'📦','label'=>'Inventario',    'sub'=>'Productos y stock',     'color'=>'#FFF8E1','ic'=>'#F57F17'],
        ['route'=>'admin.auditoria.index',   'icon'=>'🔍','label'=>'Auditoría',     'sub'=>'Logs del sistema',      'color'=>'#F1F8E9','ic'=>'#558B2F'],
        ['route'=>'2fa.setup',               'icon'=>'🔐','label'=>'Seguridad 2FA', 'sub'=>'Autenticación',         'color'=>'#FFEBEE','ic'=>'#C62828'],
    ] as $item)
    <a href="{{ route($item['route']) }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px;">
        <div style="width:42px; height:42px; background:{{ $item['color'] }}; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px; flex-shrink:0;">{{ $item['icon'] }}</div>
        <div>
            <p style="font-size:13px; font-weight:700; color:#1A2E1A; margin-bottom:2px;">{{ $item['label'] }}</p>
            <p style="font-size:11px; color:#6B8F6B;">{{ $item['sub'] }}</p>
        </div>
    </a>
    @endforeach
</div>

{{-- ===== RECEPCIÓN ===== --}}
@elseif(Auth::user()->rol?->nombre === 'recepcion')
<div style="background:linear-gradient(135deg,#1565C0,#1976D2); border-radius:16px; padding:24px; margin-bottom:24px; color:#fff; display:flex; align-items:center; gap:16px;">
    <div style="font-size:44px;">📋</div>
    <div>
        <h2 style="font-size:18px; font-weight:700; margin-bottom:2px;">¡Hola, {{ Auth::user()->name }}!</h2>
        <p style="opacity:0.8; font-size:13px;">Panel de recepción</p>
    </div>
</div>
<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:14px;">
    @foreach([
        ['route'=>'recepcion.citas.index',    'icon'=>'📅','label'=>'Citas',         'sub'=>'Gestionar citas'],
        ['route'=>'recepcion.solicitudes.index','icon'=>'🔍','label'=>'Solicitudes', 'sub'=>'Aprobar pendientes'],
        ['route'=>'recepcion.clientes.index', 'icon'=>'🐶','label'=>'Clientes',      'sub'=>'Ver y buscar'],
        ['route'=>'recepcion.pagos.index',    'icon'=>'💰','label'=>'Pagos',         'sub'=>'Registrar cobros'],
    ] as $item)
    <a href="{{ route($item['route']) }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:14px;">
        <div style="font-size:32px;">{{ $item['icon'] }}</div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#1A2E1A; margin-bottom:2px;">{{ $item['label'] }}</p>
            <p style="font-size:12px; color:#6B8F6B;">{{ $item['sub'] }}</p>
        </div>
    </a>
    @endforeach
</div>

{{-- ===== GROOMER ===== --}}
@elseif(Auth::user()->rol?->nombre === 'groomer')
<div style="background:linear-gradient(135deg,#1B5E20,#388E3C); border-radius:16px; padding:24px; margin-bottom:24px; color:#fff; display:flex; align-items:center; gap:16px;">
    <div style="font-size:44px;">✂️</div>
    <div>
        <h2 style="font-size:18px; font-weight:700; margin-bottom:2px;">¡Hola, {{ Auth::user()->name }}!</h2>
        <p style="opacity:0.8; font-size:13px;">Panel del groomer</p>
    </div>
</div>
<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:14px;">
    <a href="{{ route('groomer.agenda.index') }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:14px;">
        <div style="font-size:32px;">📅</div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#1A2E1A; margin-bottom:2px;">Mi Agenda</p>
            <p style="font-size:12px; color:#6B8F6B;">Citas del día</p>
        </div>
    </a>
    <a href="{{ route('password.cambiar') }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:14px;">
        <div style="font-size:32px;">🔐</div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#1A2E1A; margin-bottom:2px;">Mi cuenta</p>
            <p style="font-size:12px; color:#6B8F6B;">Cambiar contraseña</p>
        </div>
    </a>
</div>
@endif

@endsection