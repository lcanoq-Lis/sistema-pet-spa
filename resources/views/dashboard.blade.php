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
        <div class="stat-card" style="opacity:0.6; text-align:center;">
            <div style="font-size:40px;">📅</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mis Citas</p>
            <p style="font-size:12px; color:#a1887f;">Próximamente</p>
        </div>
        <div class="stat-card" style="opacity:0.6; text-align:center;">
            <div style="font-size:40px;">🐶</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mis Mascotas</p>
            <p style="font-size:12px; color:#a1887f;">Próximamente</p>
        </div>
        <div class="stat-card" style="opacity:0.6; text-align:center;">
            <div style="font-size:40px;">🧾</div>
            <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mis Facturas</p>
            <p style="font-size:12px; color:#a1887f;">Próximamente</p>
        </div>
    </div>
</div>

{{-- ========== VISTA ADMIN ========== --}}
@elseif(Auth::user()->rol?->nombre === 'admin')

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="stat-card">
        <div style="font-size:32px; margin-bottom:8px;">👥</div>
        <p style="font-size:26px; font-weight:800; color:#5d4037;">--</p>
        <p style="font-size:13px; color:#a1887f;">Clientes</p>
    </div>
    <div class="stat-card">
        <div style="font-size:32px; margin-bottom:8px;">📅</div>
        <p style="font-size:26px; font-weight:800; color:#5d4037;">--</p>
        <p style="font-size:13px; color:#a1887f;">Citas hoy</p>
    </div>
    <div class="stat-card">
        <div style="font-size:32px; margin-bottom:8px;">✂️</div>
        <p style="font-size:26px; font-weight:800; color:#5d4037;">--</p>
        <p style="font-size:13px; color:#a1887f;">Groomers</p>
    </div>
    <div class="stat-card">
        <div style="font-size:32px; margin-bottom:8px;">💰</div>
        <p style="font-size:26px; font-weight:800; color:#5d4037;">--</p>
        <p style="font-size:13px; color:#a1887f;">Ingresos hoy</p>
    </div>
</div>

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white;">
    <div class="flex items-center gap-4">
        <div style="font-size:60px;">🐾</div>
        <div>
            <h2 style="font-size:22px; font-weight:800;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.9; font-size:13px;">{{ Auth::user()->email }}</p>
            <p style="opacity:0.8; font-size:12px; margin-top:4px;">Rol: <strong>Administrador</strong></p>
        </div>
    </div>
</div>

<h3 style="font-size:16px; font-weight:700; color:#5d4037; margin-bottom:16px;">⚡ Accesos rápidos</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <a href="{{ route('admin.personal.index') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); border-radius:12px; padding:14px; font-size:24px;">👥</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Gestionar Personal</p>
            <p style="font-size:12px; color:#a1887f;">Groomers y recepción</p>
        </div>
    </a>
    <a href="{{ route('2fa.setup') }}" class="stat-card flex items-center gap-4" style="text-decoration:none;">
        <div style="background:linear-gradient(135deg,#43a047,#66bb6a); border-radius:12px; padding:14px; font-size:24px;">🔐</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Seguridad 2FA</p>
            <p style="font-size:12px; color:#a1887f;">Autenticación doble factor</p>
        </div>
    </a>
    <div class="stat-card flex items-center gap-4" style="opacity:0.5;">
        <div style="background:#e0e0e0; border-radius:12px; padding:14px; font-size:24px;">📊</div>
        <div>
            <p style="font-weight:700; color:#5d4037;">Reportes</p>
            <p style="font-size:12px; color:#a1887f;">Próximamente</p>
        </div>
    </div>
</div>

{{-- ========== VISTA RECEPCIÓN ========== --}}
@elseif(Auth::user()->rol?->nombre === 'recepcion')

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#1565c0,#1976d2); color:white;">
    <div class="flex items-center gap-4">
        <div style="font-size:60px;">📋</div>
        <div>
            <h2 style="font-size:22px; font-weight:800;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.9; font-size:13px;">{{ Auth::user()->email }}</p>
            <p style="opacity:0.8; font-size:12px; margin-top:4px;">Rol: <strong>Recepción</strong></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="stat-card" style="opacity:0.6; text-align:center;">
        <div style="font-size:40px;">📅</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Citas</p>
        <p style="font-size:12px; color:#a1887f;">Próximamente</p>
    </div>
    <div class="stat-card" style="opacity:0.6; text-align:center;">
        <div style="font-size:40px;">🐶</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Clientes</p>
        <p style="font-size:12px; color:#a1887f;">Próximamente</p>
    </div>
    <div class="stat-card" style="opacity:0.6; text-align:center;">
        <div style="font-size:40px;">🧾</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Facturas</p>
        <p style="font-size:12px; color:#a1887f;">Próximamente</p>
    </div>
</div>

{{-- ========== VISTA GROOMER ========== --}}
@elseif(Auth::user()->rol?->nombre === 'groomer')

<div class="stat-card mb-6" style="background:linear-gradient(135deg,#2e7d32,#43a047); color:white;">
    <div class="flex items-center gap-4">
        <div style="font-size:60px;">✂️</div>
        <div>
            <h2 style="font-size:22px; font-weight:800;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.9; font-size:13px;">{{ Auth::user()->email }}</p>
            <p style="opacity:0.8; font-size:12px; margin-top:4px;">Rol: <strong>Groomer</strong></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="stat-card" style="opacity:0.6; text-align:center;">
        <div style="font-size:40px;">📅</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Mis Citas de Hoy</p>
        <p style="font-size:12px; color:#a1887f;">Próximamente</p>
    </div>
    <div class="stat-card" style="opacity:0.6; text-align:center;">
        <div style="font-size:40px;">📋</div>
        <p style="font-weight:700; color:#5d4037; margin-top:8px;">Fichas de Grooming</p>
        <p style="font-size:12px; color:#a1887f;">Próximamente</p>
    </div>
</div>

@endif

@endsection