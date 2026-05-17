<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Spa 🐾</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { background: #f5f0eb; }

        .sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, #4e342e 0%, #6d4c41 50%, #5d4037 100%);
            position: fixed;
            top: 0; left: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #ffccbc;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            border-radius: 10px;
            margin: 2px 10px;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            background: transparent;
            width: calc(100% - 20px);
        }
        .sidebar-link:hover { background: rgba(255,112,67,0.3); color: white; }
        .sidebar-section {
            color: #a1887f;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 16px 20px 8px;
        }
        .main-content { margin-left: 260px; min-height: 100vh; }
        .topbar {
            background: white;
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .btn-primary {
            background: linear-gradient(135deg, #ff7043, #ff8f00);
            color: white; font-weight: 600;
            padding: 10px 20px; border-radius: 10px;
            border: none; cursor: pointer;
            transition: opacity 0.2s;
            font-family: 'Poppins', sans-serif; font-size: 14px;
        }
        .btn-primary:hover { opacity: 0.9; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .page-enter { animation: fadeInUp 0.3s ease forwards; }
    </style>
</head>
<body>

{{-- SIDEBAR --}}
<div class="sidebar">
    {{-- Logo --}}
    <div style="padding:24px 20px; border-bottom:1px solid rgba(255,255,255,0.1);">
        <div class="flex items-center gap-3">
            <span style="font-size:32px;">🐾</span>
            <div>
                <p style="color:white; font-weight:800; font-size:18px; line-height:1;">Pet Spa</p>
                <p style="color:#ffab91; font-size:11px;">Panel de gestión</p>
            </div>
        </div>
    </div>

    {{-- Usuario --}}
    <div style="padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.1);">
        <p style="color:#ffab91; font-size:11px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Usuario</p>
        <p style="color:white; font-weight:600; font-size:14px; margin-top:4px;">{{ Auth::user()->name }}</p>
        <span style="background:rgba(255,112,67,0.3); color:#ffab91; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; display:inline-block; margin-top:4px;">
            {{ ucfirst(Auth::user()->rol?->nombre ?? 'Sin rol') }}
        </span>
    </div>

    {{-- Menú según rol --}}
    <nav style="padding:16px 0; flex:1; overflow-y:auto;">

        <p class="sidebar-section">Principal</p>
        <a href="/dashboard" class="sidebar-link">🏠 Dashboard</a>

        {{-- ADMIN --}}
        @if(Auth::user()->rol?->nombre === 'admin')
            <p class="sidebar-section">Administración</p>
            <a href="{{ route('admin.personal.index') }}" class="sidebar-link">👥 Personal</a>
            <a href="{{ route('2fa.setup') }}" class="sidebar-link">🔐 Seguridad 2FA</a>

            <p class="sidebar-section">Gestión</p>
            <a href="{{ route('recepcion.citas.index') }}" class="sidebar-link">📅 Citas</a>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">🐶 Clientes</a>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">🧾 Facturas</a>

            <a href="{{ route('admin.productos.index') }}" class="sidebar-link">📦 Productos</a>
            <p class="sidebar-section">Inventario</p>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">📦 Productos</a>
            <a href="{{ route('admin.servicios.index') }}" class="sidebar-link">✂️ Servicios</a>

            <p class="sidebar-section">Análisis</p>
            <a href="{{ route('admin.reportes.index') }}" class="sidebar-link">📊 Reportes</a>
            <a href="{{ route('admin.auditoria.index') }}" class="sidebar-link">🔍 Auditoría</a>
            <a href="{{ route('admin.notificaciones.index') }}" class="sidebar-link">🔔 Notificaciones</a>
            @endif

        {{-- RECEPCIÓN --}}
        @if(Auth::user()->rol?->nombre === 'recepcion')
            <p class="sidebar-section">Mi trabajo</p>
            <a href="{{ route('recepcion.citas.index') }}" class="sidebar-link">📅 Citas</a>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">🐶 Clientes</a>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">🧾 Facturas</a>
        @endif

        {{-- GROOMER --}}
        @if(Auth::user()->rol?->nombre === 'groomer')
            <p class="sidebar-section">Mi trabajo</p>
            <a href="{{ route('groomer.agenda.index') }}" class="sidebar-link">📅 Mi Agenda</a>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">📋 Fichas Grooming</a>
        @endif

        {{-- CLIENTE --}}
        @if(Auth::user()->rol?->nombre === 'cliente')
            <p class="sidebar-section">Mi cuenta</p>
            <a href="{{ route('cliente.mascotas.index') }}" class="sidebar-link">🐾 Mis Mascotas</a>
            <a href="{{ route('cliente.citas.index') }}" class="sidebar-link">📅 Mis Citas</a>
            <a href="#" class="sidebar-link" style="opacity:0.5; cursor:not-allowed;">🧾 Mis Facturas</a>
            <a href="{{ route('tienda.index') }}" class="sidebar-link">🛍️ Tienda</a>
            @endif

    </nav>
        {{-- Mi cuenta - todos los roles --}}
        <p class="sidebar-section">Mi cuenta</p>
        <a href="{{ route('password.cambiar') }}" class="sidebar-link">🔐 Cambiar contraseña</a>
    {{-- Logout --}}
    <div style="padding:16px 20px; border-top:1px solid rgba(255,255,255,0.1);">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sidebar-link" style="background:rgba(239,83,80,0.2); color:#ef9a9a;">
                🚪 Cerrar sesión
            </button>
        </form>
    </div>
</div>

{{-- CONTENIDO PRINCIPAL --}}
<div class="main-content">
    <div class="topbar">
        <div>
            <h1 style="font-size:20px; font-weight:700; color:#5d4037;">@yield('page-title', 'Dashboard')</h1>
            <p style="font-size:12px; color:#a1887f;">@yield('page-subtitle', 'Bienvenido al sistema')</p>
        </div>
        <div style="font-size:13px; color:#8d6e63;">
            📅 {{ now()->locale('es')->isoFormat('dddd, D [de] MMMM YYYY') }}
        </div>
    </div>

    @if(session('status'))
    <div style="margin:16px 24px 0; background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px;">
        ✅ {{ session('status') }}
    </div>
    @endif

    <div class="page-enter" style="padding:24px;">
        @yield('content')
    </div>
</div>

</body>
</html>