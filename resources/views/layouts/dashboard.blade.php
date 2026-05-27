<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Spa — @yield('page-title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand:            #ff6b35;
            --brand-dark:       #d94f1e;
            --brand-light:      #fff4f0;
            --amber:            #f59e0b;
            --sidebar-bg:       #141010;
            --sidebar-w:        256px;
            --radius-sm:        8px;
            --radius-md:        12px;
            --radius-lg:        18px;
            --radius-xl:        24px;
            --shadow-sm:        0 1px 4px rgba(0,0,0,.06);
            --shadow-md:        0 4px 16px rgba(0,0,0,.08);
            --shadow-lg:        0 12px 40px rgba(0,0,0,.12);
            --text-primary:     #1a1210;
            --text-secondary:   #7a6560;
            --text-muted:       #b5a09a;
            --border:           #ede8e3;
            --bg:               #f9f5f2;
            --surface:          #ffffff;
        }

        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        
        html { height: 100%; }
        
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
        }

        /* ══════════════════════════════
           SIDEBAR
        ══════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 300;
            transition: transform .3s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
        }

        /* Decoración sutil */
        .sidebar::after {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 200px; height: 200px;
            background: radial-gradient(circle, rgba(255,107,53,.15) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Logo */
        .sb-logo {
            padding: 22px 20px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,.05);
        }
        .sb-logo-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, var(--brand), var(--amber));
            border-radius: var(--radius-md);
            display: grid; place-items: center;
            font-size: 20px;
            box-shadow: 0 4px 14px rgba(255,107,53,.45);
            flex-shrink: 0;
        }
        .sb-logo-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 17px; font-weight: 800;
            color: white; line-height: 1.1;
        }
        .sb-logo-sub { font-size: 10px; color: rgba(255,255,255,.3); margin-top: 2px; }

        /* Perfil */
        .sb-profile {
            padding: 14px 16px;
            margin: 10px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,.04);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sb-avatar {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--brand), var(--amber));
            border-radius: 50%;
            display: grid; place-items: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; font-weight: 800;
            color: white;
            flex-shrink: 0;
        }
        .sb-profile-name {
            font-size: 13px; font-weight: 600;
            color: white; line-height: 1.2;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .sb-role-badge {
            font-size: 9px; font-weight: 700;
            color: #ffb39a;
            background: rgba(255,107,53,.2);
            padding: 2px 8px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .6px;
            display: inline-block;
            margin-top: 3px;
        }

        /* Nav */
        .sb-nav { flex: 1; overflow-y: auto; padding: 8px 0 16px; }
        .sb-nav::-webkit-scrollbar { width: 2px; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); }

        .sb-section {
            font-size: 9.5px; font-weight: 700;
            color: rgba(255,255,255,.2);
            text-transform: uppercase;
            letter-spacing: 1.4px;
            padding: 18px 20px 6px;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            margin: 1px 10px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.5);
            text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: all .18s;
            border: none; cursor: pointer;
            background: transparent;
            width: calc(100% - 20px);
            font-family: 'DM Sans', sans-serif;
        }
        .sb-link:hover {
            background: rgba(255,107,53,.12);
            color: rgba(255,255,255,.9);
            transform: translateX(3px);
        }
        .sb-link.active {
            background: linear-gradient(90deg, rgba(255,107,53,.25), rgba(255,107,53,.08));
            color: #ffb39a;
            font-weight: 600;
            border-left: 2px solid var(--brand);
        }
        .sb-link.disabled {
            opacity: .28; cursor: not-allowed; pointer-events: none;
        }
        .sb-icon {
            width: 28px; height: 28px;
            display: grid; place-items: center;
            border-radius: var(--radius-sm);
            font-size: 14px;
            background: rgba(255,255,255,.05);
            flex-shrink: 0;
        }

        /* Footer */
        .sb-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,.05);
        }
        .sb-logout {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 14px;
            border-radius: var(--radius-sm);
            color: #fca5a5;
            background: rgba(239,68,68,.08);
            border: none; cursor: pointer;
            font-size: 13px; font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            width: 100%;
            transition: all .18s;
        }
        .sb-logout:hover { background: rgba(239,68,68,.18); }

        /* Mobile overlay */
        .sb-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.55);
            backdrop-filter: blur(6px);
            z-index: 299;
        }

        /* ══════════════════════════════
           MAIN
        ══════════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left .3s;
        }

        /* Topbar */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            height: 62px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .topbar-left { display: flex; align-items: center; gap: 16px; }
        .topbar-burger {
            display: none;
            background: none; border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            font-size: 22px;
            transition: background .15s;
            line-height: 1;
        }
        .topbar-burger:hover { background: var(--bg); }
        .topbar-title {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 17px; font-weight: 700;
            color: var(--text-primary);
        }
        .topbar-sub {
            font-size: 12px; color: var(--text-muted);
            margin-top: 1px;
        }
        .topbar-date {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: var(--text-secondary);
            background: var(--bg);
            padding: 6px 14px;
            border-radius: 20px;
            border: 1px solid var(--border);
        }

        /* Page content */
        .page {
            flex: 1;
            padding: 28px;
        }

        /* ══════════════════════════════
           COMPONENTS
        ══════════════════════════════ */
        .card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: transform .2s, box-shadow .2s;
        }
        .card:hover { box-shadow: var(--shadow-md); }

        .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 22px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: transform .2s, box-shadow .2s;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-md);
            font-size: 13px; font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer; border: none;
            text-decoration: none;
            transition: all .18s;
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--brand), var(--amber));
            color: white;
            box-shadow: 0 3px 10px rgba(255,107,53,.35);
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(255,107,53,.4); opacity: .95; }
        .btn-secondary {
            background: var(--surface);
            color: var(--text-primary);
            border: 1.5px solid var(--border);
        }
        .btn-secondary:hover { border-color: var(--brand); color: var(--brand); }
        .btn-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1.5px solid #fecaca;
        }
        .btn-danger:hover { background: #fee2e2; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }

        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-md);
            font-size: 13px; font-weight: 500;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
        }
        .alert-success { background: #f0fdf4; color: #15803d; border-left: 3px solid #22c55e; }
        .alert-error   { background: #fef2f2; color: #dc2626; border-left: 3px solid #ef4444; }
        .alert-info    { background: #eff6ff; color: #1d4ed8; border-left: 3px solid #3b82f6; }

        /* Tables */
        .table-wrap { overflow-x: auto; border-radius: var(--radius-lg); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: var(--bg); }
        th {
            padding: 12px 16px;
            text-align: left;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 11px; font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .8px;
            white-space: nowrap;
        }
        td { padding: 13px 16px; border-bottom: 1px solid var(--border); color: var(--text-primary); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #faf7f5; }

        /* Forms */
        .form-label {
            display: block;
            font-size: 12px; font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-md);
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'DM Sans', sans-serif;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(255,107,53,.1);
        }
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23b5a09a' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .32s ease forwards; }

        /* ══════════════════════════════
           RESPONSIVE
        ══════════════════════════════ */
        @media (max-width: 1024px) {
            :root { --sidebar-w: 220px; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 40px rgba(0,0,0,.35);
            }
            .sb-overlay.open { display: block; }
            .main { margin-left: 0 !important; }
            .topbar-burger { display: flex; align-items: center; }
            .topbar-date { display: none; }
            .topbar { padding: 0 16px; }
            .page { padding: 16px; }
        }

        @media (max-width: 480px) {
            .topbar-title { font-size: 15px; }
        }
    </style>
</head>
<body>

<div class="sb-overlay" id="sb-overlay" onclick="closeSidebar()"></div>

{{-- ═══════ SIDEBAR ═══════ --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-logo">
        <div class="sb-logo-icon">🐾</div>
        <div>
            <div class="sb-logo-name">Pet Spa</div>
            <div class="sb-logo-sub">Sistema de gestión</div>
        </div>
    </div>

    <div class="sb-profile">
        <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div style="overflow:hidden;">
            <div class="sb-profile-name">{{ Auth::user()->name }}</div>
            <span class="sb-role-badge">{{ ucfirst(Auth::user()->rol?->nombre ?? 'Sin rol') }}</span>
        </div>
    </div>

    <nav class="sb-nav">

        <p class="sb-section">Principal</p>
        <a href="/dashboard" class="sb-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="sb-icon">🏠</span> Dashboard
        </a>

        @if(Auth::user()->rol?->nombre === 'admin')
            <p class="sb-section">Administración</p>
            <a href="{{ route('admin.personal.index') }}" class="sb-link {{ request()->routeIs('admin.personal.*') ? 'active' : '' }}">
                <span class="sb-icon">👥</span> Personal
            </a>
            <a href="{{ route('admin.horarios.index') }}" class="sb-link {{ request()->routeIs('admin.horarios.*') ? 'active' : '' }}">
                <span class="sb-icon">⏰</span> Horarios
            </a>
            <a href="{{ route('2fa.setup') }}" class="sb-link {{ request()->routeIs('2fa.setup') ? 'active' : '' }}">
                <span class="sb-icon">🔐</span> Seguridad 2FA
            </a>

            <p class="sb-section">Operaciones</p>
            <a href="{{ route('recepcion.citas.index') }}" class="sb-link {{ request()->routeIs('recepcion.citas.*') ? 'active' : '' }}">
                <span class="sb-icon">📅</span> Citas
            </a>
            <a href="{{ route('recepcion.calendario') }}" class="sb-link {{ request()->routeIs('recepcion.calendario') ? 'active' : '' }}">
                <span class="sb-icon">📆</span> Calendario
            </a>
            <a href="{{ route('recepcion.pagos.index') }}" class="sb-link {{ request()->routeIs('recepcion.pagos.*') ? 'active' : '' }}">
                <span class="sb-icon">💳</span> Pagos
            </a>
            <a href="{{ route('recepcion.solicitudes.index') }}" class="sb-link {{ request()->routeIs('recepcion.solicitudes.*') ? 'active' : '' }}">
                <span class="sb-icon">🔍</span> Solicitudes
            </a>
            <a href="{{ route('admin.promociones.index') }}" class="sb-link {{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}">
                <span class="sb-icon">🏷️</span> Promociones
            </a>

            <p class="sb-section">Inventario</p>
            <a href="{{ route('admin.productos.index') }}" class="sb-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                <span class="sb-icon">📦</span> Productos
            </a>
            <a href="{{ route('admin.servicios.index') }}" class="sb-link {{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
                <span class="sb-icon">✂️</span> Servicios
            </a>

            <p class="sb-section">Análisis</p>
            <a href="{{ route('admin.reportes.index') }}" class="sb-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}">
                <span class="sb-icon">📊</span> Reportes
            </a>
            <a href="{{ route('admin.auditoria.index') }}" class="sb-link {{ request()->routeIs('admin.auditoria.*') ? 'active' : '' }}">
                <span class="sb-icon">🔍</span> Auditoría
            </a>
            <a href="{{ route('admin.notificaciones.index') }}" class="sb-link {{ request()->routeIs('admin.notificaciones.*') ? 'active' : '' }}">
                <span class="sb-icon">🔔</span> Notificaciones
            </a>
        @endif

        @if(Auth::user()->rol?->nombre === 'recepcion')
            <p class="sb-section">Mi trabajo</p>
            <a href="{{ route('recepcion.citas.index') }}" class="sb-link {{ request()->routeIs('recepcion.citas.*') ? 'active' : '' }}">
                <span class="sb-icon">📅</span> Citas
            </a>
            <a href="{{ route('recepcion.calendario') }}" class="sb-link {{ request()->routeIs('recepcion.calendario') ? 'active' : '' }}">
                <span class="sb-icon">📆</span> Calendario
            </a>
            <a href="{{ route('recepcion.pagos.index') }}" class="sb-link {{ request()->routeIs('recepcion.pagos.*') ? 'active' : '' }}">
                <span class="sb-icon">💳</span> Pagos
            </a>
            <a href="{{ route('recepcion.clientes.index') }}" class="sb-link {{ request()->routeIs('recepcion.clientes.*') ? 'active' : '' }}">
                <span class="sb-icon">🐶</span> Clientes
            </a>
            4. Agrega el link en el sidebar dentro de la sección de recepción:
            <a href="{{ route('recepcion.pagos.cierre') }}" class="sb-link">
                    <span class="sb-icon">🏦</span> Cierre de caja
                </a>
        @endif

        @if(Auth::user()->rol?->nombre === 'groomer')
            <p class="sb-section">Mi trabajo</p>
            <a href="{{ route('groomer.agenda.index') }}" class="sb-link {{ request()->routeIs('groomer.agenda.*') ? 'active' : '' }}">
                <span class="sb-icon">📅</span> Mi Agenda
            </a>
            <a href="#" class="sb-link disabled">
                <span class="sb-icon">📋</span> Fichas Grooming
            </a>
        @endif

        @if(Auth::user()->rol?->nombre === 'cliente')
            <p class="sb-section">Mi cuenta</p>
            <a href="{{ route('cliente.mascotas.index') }}" class="sb-link {{ request()->routeIs('cliente.mascotas.*') ? 'active' : '' }}">
                <span class="sb-icon">🐾</span> Mis Mascotas
            </a>
            <a href="{{ route('cliente.citas.index') }}" class="sb-link {{ request()->routeIs('cliente.citas.*') ? 'active' : '' }}">
                <span class="sb-icon">📅</span> Mis Citas
            </a>
            <a href="{{ route('cliente.tienda.index') }}" class="sb-link {{ request()->routeIs('cliente.tienda.*') ? 'active' : '' }}">
                <span class="sb-icon">🛍️</span> Tienda
            </a>
            <a href="{{ route('cliente.perfil.edit') }}" class="sb-link {{ request()->routeIs('cliente.perfil.*') ? 'active' : '' }}">
                <span class="sb-icon">👤</span> Mi Perfil
            </a>
        @endif

        <p class="sb-section">Cuenta</p>
        <a href="{{ route('password.cambiar') }}" class="sb-link {{ request()->routeIs('password.cambiar') ? 'active' : '' }}">
            <span class="sb-icon">🔑</span> Cambiar contraseña
        </a>

    </nav>

    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <span>→</span> Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- ═══════ MAIN ═══════ --}}
<div class="main" id="main">

    <header class="topbar">
        <div class="topbar-left">
            <button class="topbar-burger" onclick="toggleSidebar()">☰</button>
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-sub">@yield('page-subtitle', '')</div>
            </div>
        </div>
        <div class="topbar-date">
            📅 {{ now()->locale('es')->isoFormat('ddd D MMM, YYYY') }}
        </div>
    </header>

    <main class="page fade-up">

        @if(session('status'))
            <div class="alert alert-success">✅ {{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">❌ {{ $errors->first() }}</div>
        @endif

        @yield('content')

    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('open');
    document.getElementById('sb-overlay').classList.toggle('open');
    document.body.style.overflow = document.getElementById('sidebar').classList.contains('open') ? 'hidden' : '';
}
function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sb-overlay').classList.remove('open');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
</script>

</body>
</html>