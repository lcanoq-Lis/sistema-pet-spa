<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Spa — @yield('page-title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        :root {
            --brand:          #3a9e47;
            --brand-dark:     #1B5E20;
            --brand-glow:     rgba(58,158,71,.18);
            --sidebar-bg:     #0f1f0f;
            --sidebar-w:      255px;
            --sidebar-border: rgba(255,255,255,.06);
            --radius-sm:      6px;
            --radius-md:      10px;
            --radius-lg:      16px;
            --radius-xl:      22px;
            --text-primary:   #111c11;
            --text-secondary: #4a6a4a;
            --text-muted:     #8aaa8a;
            --border:         #e0eae0;
            --bg:             #f4f7f4;
            --surface:        #ffffff;
            --shadow-sm:      0 1px 3px rgba(0,0,0,.04), 0 1px 2px rgba(0,0,0,.03);
            --shadow-md:      0 4px 12px rgba(0,0,0,.06), 0 2px 4px rgba(0,0,0,.04);
            --shadow-lg:      0 16px 48px rgba(0,0,0,.08), 0 4px 12px rgba(0,0,0,.05);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { height: 100%; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ══════════════════════════
           SIDEBAR
        ══════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 300;
            transition: transform .28s cubic-bezier(.4,0,.2,1);
            overflow: hidden;
            border-right: 1px solid var(--sidebar-border);
        }

        /* Textura de luz sutil en la parte superior */
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 200px;
            background: radial-gradient(ellipse 180px 120px at 50% -20px, rgba(58,158,71,.12), transparent);
            pointer-events: none;
            z-index: 0;
        }

        /* ── Logo ── */
        .sb-logo {
            padding: 20px 18px 16px;
            display: flex;
            align-items: center;
            gap: 11px;
            position: relative;
            z-index: 1;
        }
        .sb-logo::after {
            content: '';
            position: absolute;
            bottom: 0; left: 18px; right: 18px;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--sidebar-border), transparent);
        }
        .sb-logo-mark {
            width: 36px; height: 36px;
            background: linear-gradient(145deg, #3a9e47, #2E7D32);
            border-radius: var(--radius-md);
            display: grid; place-items: center;
            box-shadow: 0 0 0 1px rgba(255,255,255,.1), 0 4px 16px rgba(58,158,71,.3);
            flex-shrink: 0;
            position: relative;
        }
        .sb-logo-mark i { font-size: 18px; color: #fff; }
        .sb-logo-text {
            font-family: 'Sora', sans-serif;
            font-size: 15px; font-weight: 700;
            color: #fff;
            letter-spacing: -.2px;
            line-height: 1.1;
        }
        .sb-logo-sub {
            font-size: 10px;
            color: rgba(255,255,255,.3);
            font-weight: 400;
            margin-top: 2px;
            letter-spacing: .2px;
        }

        /* ── Perfil ── */
        .sb-profile {
            margin: 12px 10px 4px;
            padding: 10px 12px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.06);
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }
        .sb-avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #3a9e47, #1B5E20);
            border-radius: 50%;
            display: grid; place-items: center;
            font-family: 'Sora', sans-serif;
            font-size: 13px; font-weight: 700;
            color: white;
            flex-shrink: 0;
            box-shadow: 0 0 0 2px rgba(58,158,71,.25);
        }
        .sb-profile-name {
            font-size: 12.5px; font-weight: 600;
            color: rgba(255,255,255,.9);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            line-height: 1.3;
        }
        .sb-role-badge {
            font-size: 9px; font-weight: 600;
            color: #86efac;
            background: rgba(58,158,71,.2);
            border: 1px solid rgba(58,158,71,.3);
            padding: 1px 7px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .8px;
            display: inline-block;
            margin-top: 2px;
        }

        /* ── Nav ── */
        .sb-nav { flex: 1; overflow-y: auto; padding: 6px 0 12px; position: relative; z-index: 1; }
        .sb-nav::-webkit-scrollbar { width: 2px; }
        .sb-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,.08); border-radius: 2px; }

        .sb-section {
            font-size: 9px; font-weight: 600;
            color: rgba(255,255,255,.22);
            text-transform: uppercase;
            letter-spacing: 1.6px;
            padding: 16px 18px 5px;
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 12px;
            margin: 1px 8px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.42);
            text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: all .15s ease;
            border: none; cursor: pointer;
            background: transparent;
            width: calc(100% - 16px);
            font-family: 'Inter', sans-serif;
            letter-spacing: -.1px;
        }
        .sb-link:hover {
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.85);
        }
        .sb-link.active {
            background: rgba(58,158,71,.15);
            color: #86efac;
            font-weight: 600;
            border-left: 2px solid #3a9e47;
            padding-left: 10px;
        }
        .sb-link.active .sb-icon { background: rgba(58,158,71,.2); color: #86efac; }
        .sb-icon {
            width: 26px; height: 26px;
            display: grid; place-items: center;
            border-radius: 6px;
            font-size: 14px;
            background: rgba(255,255,255,.05);
            color: rgba(255,255,255,.35);
            flex-shrink: 0;
            transition: all .15s;
        }
        .sb-link:hover .sb-icon { background: rgba(255,255,255,.08); color: rgba(255,255,255,.7); }

        /* ── Footer ── */
        .sb-footer {
            padding: 10px;
            border-top: 1px solid var(--sidebar-border);
            position: relative; z-index: 1;
        }
        .sb-logout {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            color: rgba(252,165,165,.65);
            background: transparent;
            border: none; cursor: pointer;
            font-size: 13px; font-weight: 500;
            font-family: 'Inter', sans-serif;
            width: 100%;
            transition: all .15s;
        }
        .sb-logout:hover { background: rgba(239,68,68,.08); color: #fca5a5; }
        .sb-logout i { font-size: 15px; }

        /* Mobile overlay */
        .sb-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.6);
            z-index: 299;
        }

        /* ══════════════════════════
           MAIN CONTENT
        ══════════════════════════ */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left .28s;
        }

        /* ── Topbar ── */
        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 100;
            box-shadow: var(--shadow-sm);
        }
        .topbar-left { display: flex; align-items: center; gap: 14px; }
        .topbar-burger {
            display: none;
            background: none; border: none;
            cursor: pointer;
            padding: 6px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            font-size: 20px;
            transition: background .15s;
            line-height: 1;
        }
        .topbar-burger:hover { background: var(--bg); }
        .topbar-divider {
            width: 1px; height: 20px;
            background: var(--border);
            display: none;
        }
        .topbar-title {
            font-family: 'Sora', sans-serif;
            font-size: 15px; font-weight: 700;
            color: var(--text-primary);
            letter-spacing: -.2px;
        }
        .topbar-sub {
            font-size: 11.5px;
            color: var(--text-muted);
            margin-top: 1px;
            font-weight: 400;
        }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .topbar-date {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; font-weight: 500;
            color: var(--text-secondary);
            background: var(--bg);
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid var(--border);
            letter-spacing: -.1px;
        }
        .topbar-date i { font-size: 13px; color: var(--brand); }

        /* ── Page ── */
        .page {
            flex: 1;
            padding: 26px 28px;
        }

        /* ══════════════════════════
           COMPONENTS
        ══════════════════════════ */
        .card, .stat-card {
            background: var(--surface);
            border-radius: var(--radius-lg);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .card:hover { box-shadow: var(--shadow-md); }
        .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 16px;
            border-radius: var(--radius-md);
            font-size: 13px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; border: none;
            text-decoration: none;
            transition: all .15s;
            letter-spacing: -.1px;
        }
        .btn-primary {
            background: var(--brand);
            color: white;
            box-shadow: 0 1px 3px rgba(58,158,71,.3), inset 0 1px 0 rgba(255,255,255,.12);
        }
        .btn-primary:hover { background: #338f3f; box-shadow: 0 4px 12px rgba(58,158,71,.35); }
        .btn-secondary {
            background: var(--surface);
            color: var(--text-primary);
            border: 1px solid var(--border);
        }
        .btn-secondary:hover { border-color: var(--brand); color: var(--brand); background: #f0faf0; }
        .btn-danger {
            background: #fef2f2; color: #dc2626;
            border: 1px solid #fecaca;
        }
        .btn-danger:hover { background: #fee2e2; }

        .badge {
            display: inline-flex; align-items: center;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px; font-weight: 600;
            letter-spacing: .1px;
        }
        .badge-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
        .badge-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }
        .badge-danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .badge-info    { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }

        .alert {
            padding: 11px 16px;
            border-radius: var(--radius-md);
            font-size: 13px; font-weight: 500;
            margin-bottom: 18px;
            display: flex; align-items: center; gap: 10px;
            border: 1px solid;
        }
        .alert-success { background: #f0fdf4; color: #15803d; border-color: #bbf7d0; }
        .alert-error   { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
        .alert-info    { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }

        /* Tables */
        .table-wrap { overflow-x: auto; border-radius: var(--radius-lg); border: 1px solid var(--border); }
        table { width: 100%; border-collapse: collapse; font-size: 13px; }
        thead tr { background: var(--bg); }
        th {
            padding: 11px 16px;
            text-align: left;
            font-size: 10.5px; font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
            border-bottom: 1px solid var(--border);
        }
        td { padding: 12px 16px; border-bottom: 1px solid var(--border); color: var(--text-primary); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: #f7fbf7; }

        /* Forms */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 11.5px; font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: .6px;
            margin-bottom: 6px;
        }
        .form-input {
            width: 100%;
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 9px 13px;
            font-size: 13.5px;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-input:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(58,158,71,.1);
        }
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234a6a4a' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 13px center;
            padding-right: 34px;
        }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .28s ease forwards; }

        /* ══════════════════════════
           RESPONSIVE
        ══════════════════════════ */
        @media (max-width: 1024px) {
            :root { --sidebar-w: 230px; }
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 6px 0 40px rgba(0,0,0,.4);
            }
            .sb-overlay.open { display: block; }
            .main { margin-left: 0 !important; }
            .topbar-burger { display: flex; align-items: center; }
            .topbar-divider { display: block; }
            .topbar-date { display: none; }
            .topbar { padding: 0 16px; }
            .page { padding: 16px; }
        }

        @media (max-width: 480px) {
            .topbar-title { font-size: 14px; }
        }
    </style>
</head>
<body>

<div class="sb-overlay" id="sb-overlay" onclick="closeSidebar()"></div>

{{-- ═══════ SIDEBAR ═══════ --}}
<aside class="sidebar" id="sidebar">

    <div class="sb-logo">
        <div class="sb-logo-mark">
            <i class="ti ti-paw"></i>
        </div>
        <div>
            <div class="sb-logo-text">Pet Spa</div>
            <div class="sb-logo-sub">Sistema de gestión</div>
        </div>
    </div>

    <div class="sb-profile">
        <div class="sb-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        <div style="overflow:hidden; flex:1; min-width:0;">
            <div class="sb-profile-name">{{ Auth::user()->name }}</div>
            <span class="sb-role-badge">{{ ucfirst(Auth::user()->rol?->nombre ?? 'Sin rol') }}</span>
        </div>
    </div>

    <nav class="sb-nav">

        <p class="sb-section">Principal</p>
        <a href="/dashboard" class="sb-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <span class="sb-icon"><i class="ti ti-layout-dashboard"></i></span> Dashboard
        </a>

        @if(Auth::user()->rol?->nombre === 'admin')
            <p class="sb-section">Administración</p>
            <a href="{{ route('admin.personal.index') }}" class="sb-link {{ request()->routeIs('admin.personal.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-users"></i></span> Personal
            </a>
            <a href="{{ route('admin.horarios.index') }}" class="sb-link {{ request()->routeIs('admin.horarios.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-clock"></i></span> Horarios
            </a>
            <a href="{{ route('2fa.setup') }}" class="sb-link {{ request()->routeIs('2fa.setup') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-lock"></i></span> Seguridad 2FA
            </a>

            <p class="sb-section">Operaciones</p>
            <a href="{{ route('recepcion.citas.index') }}" class="sb-link {{ request()->routeIs('recepcion.citas.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-calendar-event"></i></span> Citas
            </a>
            <a href="{{ route('recepcion.calendario') }}" class="sb-link {{ request()->routeIs('recepcion.calendario') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-calendar-month"></i></span> Calendario
            </a>
            <a href="{{ route('recepcion.pagos.index') }}" class="sb-link {{ request()->routeIs('recepcion.pagos.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-credit-card"></i></span> Pagos
            </a>
            <a href="{{ route('recepcion.solicitudes.index') }}" class="sb-link {{ request()->routeIs('recepcion.solicitudes.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-inbox"></i></span> Solicitudes
            </a>
            <a href="{{ route('admin.promociones.index') }}" class="sb-link {{ request()->routeIs('admin.promociones.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-tag"></i></span> Promociones
            </a>

            <p class="sb-section">Inventario</p>
            <a href="{{ route('admin.productos.index') }}" class="sb-link {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-package"></i></span> Productos
            </a>
            <a href="{{ route('admin.servicios.index') }}" class="sb-link {{ request()->routeIs('admin.servicios.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-scissors"></i></span> Servicios
            </a>

            <p class="sb-section">Análisis</p>
            <a href="{{ route('admin.reportes.index') }}" class="sb-link {{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-chart-bar"></i></span> Reportes
            </a>
            <a href="{{ route('admin.auditoria.index') }}" class="sb-link {{ request()->routeIs('admin.auditoria.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-shield-search"></i></span> Auditoría
            </a>
            <a href="{{ route('admin.notificaciones.index') }}" class="sb-link {{ request()->routeIs('admin.notificaciones.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-bell"></i></span> Notificaciones
            </a>
        @endif

        @if(Auth::user()->rol?->nombre === 'recepcion')
            <p class="sb-section">Mi trabajo</p>
            <a href="{{ route('recepcion.citas.index') }}" class="sb-link {{ request()->routeIs('recepcion.citas.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-calendar-event"></i></span> Citas
            </a>
            <a href="{{ route('recepcion.calendario') }}" class="sb-link {{ request()->routeIs('recepcion.calendario') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-calendar-month"></i></span> Calendario
            </a>
            <a href="{{ route('recepcion.pagos.index') }}" class="sb-link {{ request()->routeIs('recepcion.pagos.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-credit-card"></i></span> Pagos
            </a>
            <a href="{{ route('recepcion.pagos.cierre') }}" class="sb-link {{ request()->routeIs('recepcion.pagos.cierre') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-building-bank"></i></span> Cierre de caja
            </a>
            <a href="{{ route('recepcion.clientes.index') }}" class="sb-link {{ request()->routeIs('recepcion.clientes.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-dog"></i></span> Clientes
            </a>
        @endif

        @if(Auth::user()->rol?->nombre === 'groomer')
            <p class="sb-section">Mi trabajo</p>
            <a href="{{ route('groomer.agenda.index') }}" class="sb-link {{ request()->routeIs('groomer.agenda.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-calendar-event"></i></span> Mi Agenda
            </a>
        @endif

        @if(Auth::user()->rol?->nombre === 'cliente')
            <p class="sb-section">Mi espacio</p>
            <a href="{{ route('cliente.mascotas.index') }}" class="sb-link {{ request()->routeIs('cliente.mascotas.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-paw"></i></span> Mis Mascotas
            </a>
            <a href="{{ route('cliente.citas.index') }}" class="sb-link {{ request()->routeIs('cliente.citas.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-calendar-event"></i></span> Mis Citas
            </a>
            <a href="{{ route('cliente.tienda.index') }}" class="sb-link {{ request()->routeIs('cliente.tienda.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-shopping-bag"></i></span> Tienda
            </a>
            <a href="{{ route('cliente.perfil.edit') }}" class="sb-link {{ request()->routeIs('cliente.perfil.*') ? 'active' : '' }}">
                <span class="sb-icon"><i class="ti ti-user-circle"></i></span> Mi Perfil
            </a>
        @endif

        <p class="sb-section">Cuenta</p>
        <a href="{{ route('password.cambiar') }}" class="sb-link {{ request()->routeIs('password.cambiar') ? 'active' : '' }}">
            <span class="sb-icon"><i class="ti ti-key"></i></span> Cambiar contraseña
        </a>

    </nav>

    <div class="sb-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="sb-logout">
                <i class="ti ti-logout"></i> Cerrar sesión
            </button>
        </form>
    </div>
</aside>

{{-- ═══════ MAIN ═══════ --}}
<div class="main" id="main">

    <header class="topbar">
        <div class="topbar-left">
            <button class="topbar-burger" onclick="toggleSidebar()">
                <i class="ti ti-menu-2"></i>
            </button>
            <div class="topbar-divider"></div>
            <div>
                <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
                <div class="topbar-sub">@yield('page-subtitle', '')</div>
            </div>
        </div>
        <div class="topbar-right">
            <div class="topbar-date">
                <i class="ti ti-calendar"></i>
                {{ now()->locale('es')->isoFormat('ddd D MMM, YYYY') }}
            </div>
        </div>
    </header>

    <main class="page fade-up">

        @if(session('status'))
            <div class="alert alert-success">
                <i class="ti ti-circle-check" style="font-size:16px; flex-shrink:0;"></i>
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <i class="ti ti-circle-x" style="font-size:16px; flex-shrink:0;"></i>
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')

    </main>
</div>

<script>
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const ov = document.getElementById('sb-overlay');
    sb.classList.toggle('open');
    ov.classList.toggle('open');
    document.body.style.overflow = sb.classList.contains('open') ? 'hidden' : '';
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
