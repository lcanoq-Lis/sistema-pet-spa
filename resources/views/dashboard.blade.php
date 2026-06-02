@extends('layouts.dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumen general del sistema')

{{-- Tabler Icons (agregar en layouts/dashboard.blade.php si no está) --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css"> --}}

@section('content')

{{-- ===== CLIENTE ===== --}}
@if(Auth::user()->rol?->nombre === 'cliente')
<div style="width:100%;">

    {{-- Welcome card --}}
    <div style="background:#1B5E20; border-radius:16px; padding:28px; margin-bottom:24px; color:#fff; display:flex; align-items:center; gap:20px; position:relative; overflow:hidden;">
        <div style="position:absolute; right:-20px; top:-30px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.05);"></div>
        <div style="position:absolute; right:40px; bottom:-50px; width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
        <div style="width:56px; height:56px; border-radius:16px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; color:#fff; font-size:28px; flex-shrink:0; position:relative;">
            <i class="ti ti-paw"></i>
        </div>
        <div style="position:relative;">
            <h2 style="font-size:20px; font-weight:700; margin:0 0 4px;">¡Hola, {{ Auth::user()->name }}!</h2>
            <p style="opacity:0.75; font-size:13px; margin:0;">{{ Auth::user()->email }}</p>
        </div>
    </div>

    {{-- Action cards - VERSIÓN RESPONSIVA --}}
    <div style="display:flex; flex-wrap:wrap; gap:16px; justify-content:flex-start;">
        @foreach([
            ['route'=>'cliente.citas.index',    'icon'=>'ti-calendar-event', 'label'=>'Mis Citas',   'sub'=>'Ver y solicitar',      'bg'=>'#EAF3DE','ic'=>'#3B6D11'],
            ['route'=>'cliente.mascotas.index', 'icon'=>'ti-dog',            'label'=>'Mascotas',    'sub'=>'Gestionar perfiles',   'bg'=>'#E8F5E9','ic'=>'#2E7D32'],
            ['route'=>'cliente.historial',      'icon'=>'ti-clipboard-list', 'label'=>'Historial',   'sub'=>'Servicios pasados',    'bg'=>'#F1F8E9','ic'=>'#558B2F'],
            ['route'=>'cliente.tienda.index',   'icon'=>'ti-shopping-bag',   'label'=>'Tienda',      'sub'=>'Ver productos',        'bg'=>'#FFF8E1','ic'=>'#F57F17'],
            ['route'=>'password.cambiar',       'icon'=>'ti-lock',           'label'=>'Mi cuenta',   'sub'=>'Cambiar contraseña',   'bg'=>'#FFEBEE','ic'=>'#C62828'],
        ] as $item)
        <a href="{{ route($item['route']) }}" style="flex:1 1 160px; min-width:140px; max-width:180px; text-decoration:none; background:#fff; border:0.5px solid #e0e0e0; border-radius:16px; padding:18px 12px; display:flex; flex-direction:column; align-items:center; text-align:center; gap:10px; transition:all 0.2s;">
            <div style="width:48px; height:48px; border-radius:14px; background:{{ $item['bg'] }}; display:flex; align-items:center; justify-content:center; font-size:22px; color:{{ $item['ic'] }};">
                <i class="ti {{ $item['icon'] }}"></i>
            </div>
            <div>
                <p style="font-size:13px; font-weight:700; color:#1A2E1A; margin:0 0 2px;">{{ $item['label'] }}</p>
                <p style="font-size:11px; color:#6B8F6B; margin:0;">{{ $item['sub'] }}</p>
            </div>
        </a>
        @endforeach
    </div>
</div>

{{-- ===== ADMIN ===== --}}
@elseif(Auth::user()->rol?->nombre === 'admin')

@php
    $kpis = [
        [
            'val'   => \App\Models\User::whereHas('rol', fn($q) => $q->where('nombre','cliente'))->count(),
            'label' => 'Clientes',
            'icon'  => 'ti-users',
            'bg'    => '#E8F5E9',
            'ic'    => '#2E7D32',
        ],
        [
            'val'   => \App\Models\Cita::whereDate('fecha_hora_inicio', now())->whereNotIn('estado',['cancelada'])->count(),
            'label' => 'Citas hoy',
            'icon'  => 'ti-calendar-event',
            'bg'    => '#E3F2FD',
            'ic'    => '#1565C0',
        ],
        [
            'val'   => \App\Models\Groomer::where('activo', true)->count(),
            'label' => 'Groomers',
            'icon'  => 'ti-scissors',
            'bg'    => '#F3E5F5',
            'ic'    => '#6A1B9A',
        ],
        [
            'val'   => 'Bs. ' . \App\Models\Cita::where('estado','completada')->whereMonth('fecha_hora_inicio', now()->month)->sum('precio_acordado'),
            'label' => 'Ingresos mes',
            'icon'  => 'ti-coin',
            'bg'    => '#FFF3E0',
            'ic'    => '#E65100',
        ],
    ];
@endphp

{{-- KPI cards --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px;">
    @foreach($kpis as $k)
    <div class="stat-card" style="display:flex; flex-direction:column; align-items:center; text-align:center; gap:10px;">
        <div style="width:48px; height:48px; border-radius:14px; background:{{ $k['bg'] }}; display:flex; align-items:center; justify-content:center; font-size:22px; color:{{ $k['ic'] }};">
            <i class="ti {{ $k['icon'] }}"></i>
        </div>
        <p style="font-size:22px; font-weight:800; color:{{ $k['ic'] }}; margin:0;">{{ $k['val'] }}</p>
        <p style="font-size:12px; color:#6B8F6B; margin:0;">{{ $k['label'] }}</p>
    </div>
    @endforeach
</div>

{{-- Consumo de insumos --}}
@php
    $semanaInicio   = now()->startOfWeek();
    $limiteInsumos  = (int) \App\Models\Configuracion::obtener('limite_insumos_semana', 20);
    $consumoGroomers = \App\Models\Groomer::where('activo', true)
        ->get()
        ->map(function($g) use ($semanaInicio) {
            $g->total_insumos = \App\Models\InsumoGrooming::whereHas('ficha', function($q) use ($g) {
                $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $g->id));
            })->where('estado', '!=', 'devuelto')
              ->where('creado_en', '>=', $semanaInicio)
              ->sum('cantidad');
            return $g;
        })->sortByDesc('total_insumos');
@endphp

<div class="stat-card" style="margin-bottom:20px;">
    <h3 style="font-size:15px; font-weight:700; color:#5d4037; margin-bottom:16px; display:flex; align-items:center; gap:8px;">
        <i class="ti ti-package" style="font-size:18px;"></i>
        Consumo de insumos esta semana (límite: {{ $limiteInsumos }} u.)
    </h3>
    @foreach($consumoGroomers as $g)
    @php $excede = $g->total_insumos >= $limiteInsumos; @endphp
    <div style="display:flex; align-items:center; gap:12px; padding:10px 0; border-bottom:1px solid #f5f0eb;">
        <div style="width:36px; height:36px; background:{{ $excede ? '#c62828' : '#ff7043' }}; border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:14px; flex-shrink:0;">
            {{ strtoupper(substr($g->nombre, 0, 1)) }}
        </div>
        <div style="flex:1;">
            <p style="font-size:13px; font-weight:600; color:#5d4037; margin:0;">{{ $g->nombre }}</p>
            <div style="background:#f5f0eb; border-radius:4px; height:6px; margin-top:4px; overflow:hidden;">
                <div style="height:100%; width:{{ min(100, ($g->total_insumos / $limiteInsumos) * 100) }}%; background:{{ $excede ? '#c62828' : '#ff7043' }}; border-radius:4px;"></div>
            </div>
        </div>
        <span style="font-size:13px; font-weight:700; color:{{ $excede ? '#c62828' : '#5d4037' }}; display:flex; align-items:center; gap:4px;">
            {{ $g->total_insumos }} u.
            @if($excede)
                <i class="ti ti-alert-triangle" style="font-size:15px; color:#c62828;"></i>
            @endif
        </span>
    </div>
    @endforeach
</div>

{{-- Accesos rápidos admin --}}
<h3 style="font-size:14px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:14px;">
    Accesos rápidos
</h3>
<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:14px;">
    @foreach([
        ['route'=>'admin.personal.index',  'icon'=>'ti-users',          'label'=>'Personal',      'sub'=>'Groomers y recepción', 'bg'=>'#E8F5E9','ic'=>'#2E7D32'],
        ['route'=>'admin.reportes.index',  'icon'=>'ti-chart-bar',      'label'=>'Reportes',      'sub'=>'KPIs del negocio',     'bg'=>'#E3F2FD','ic'=>'#1565C0'],
        ['route'=>'admin.servicios.index', 'icon'=>'ti-scissors',       'label'=>'Servicios',     'sub'=>'Precios y duración',   'bg'=>'#F3E5F5','ic'=>'#6A1B9A'],
        ['route'=>'admin.productos.index', 'icon'=>'ti-package',        'label'=>'Inventario',    'sub'=>'Productos y stock',    'bg'=>'#FFF8E1','ic'=>'#F57F17'],
        ['route'=>'admin.auditoria.index', 'icon'=>'ti-shield-search',  'label'=>'Auditoría',     'sub'=>'Logs del sistema',     'bg'=>'#F1F8E9','ic'=>'#558B2F'],
        ['route'=>'2fa.setup',             'icon'=>'ti-lock',           'label'=>'Seguridad 2FA', 'sub'=>'Autenticación',        'bg'=>'#FFEBEE','ic'=>'#C62828'],
    ] as $item)
    <a href="{{ route($item['route']) }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px;">
        <div style="width:44px; height:44px; background:{{ $item['bg'] }}; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; color:{{ $item['ic'] }}; flex-shrink:0;">
            <i class="ti {{ $item['icon'] }}"></i>
        </div>
        <div>
            <p style="font-size:13px; font-weight:700; color:#1A2E1A; margin:0 0 2px;">{{ $item['label'] }}</p>
            <p style="font-size:11px; color:#6B8F6B; margin:0;">{{ $item['sub'] }}</p>
        </div>
    </a>
    @endforeach
</div>

{{-- ===== RECEPCIÓN ===== --}}
@elseif(Auth::user()->rol?->nombre === 'recepcion')

{{-- Welcome card azul --}}
<div style="background:#1565C0; border-radius:16px; padding:24px 28px; margin-bottom:24px; color:#fff; display:flex; align-items:center; gap:16px; position:relative; overflow:hidden;">
    <div style="position:absolute; right:-20px; top:-30px; width:140px; height:140px; border-radius:50%; background:rgba(255,255,255,0.05);"></div>
    <div style="position:absolute; right:30px; bottom:-40px; width:100px; height:100px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
    <div style="width:52px; height:52px; border-radius:14px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0; position:relative;">
        <i class="ti ti-clipboard-list"></i>
    </div>
    <div style="position:relative;">
        <h2 style="font-size:18px; font-weight:700; margin:0 0 4px;">¡Hola, {{ Auth::user()->name }}!</h2>
        <p style="opacity:0.75; font-size:13px; margin:0;">Panel de recepción</p>
    </div>
</div>

<div style="display:grid; grid-template-columns:repeat(2,1fr); gap:14px;">
    @foreach([
        ['route'=>'recepcion.citas.index',      'icon'=>'ti-calendar-event', 'label'=>'Citas',        'sub'=>'Gestionar citas',      'bg'=>'#E3F2FD','ic'=>'#1565C0'],
        ['route'=>'recepcion.solicitudes.index','icon'=>'ti-search',         'label'=>'Solicitudes',  'sub'=>'Aprobar pendientes',   'bg'=>'#F3E5F5','ic'=>'#6A1B9A'],
        ['route'=>'recepcion.clientes.index',   'icon'=>'ti-dog',            'label'=>'Clientes',     'sub'=>'Ver y buscar',         'bg'=>'#E8F5E9','ic'=>'#2E7D32'],
        ['route'=>'recepcion.pagos.index',      'icon'=>'ti-cash',           'label'=>'Pagos',        'sub'=>'Registrar cobros',     'bg'=>'#FFF8E1','ic'=>'#F57F17'],
    ] as $item)
    <a href="{{ route($item['route']) }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:14px; padding:18px;">
        <div style="width:44px; height:44px; border-radius:12px; background:{{ $item['bg'] }}; display:flex; align-items:center; justify-content:center; font-size:22px; color:{{ $item['ic'] }}; flex-shrink:0;">
            <i class="ti {{ $item['icon'] }}"></i>
        </div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#1A2E1A; margin:0 0 2px;">{{ $item['label'] }}</p>
            <p style="font-size:12px; color:#6B8F6B; margin:0;">{{ $item['sub'] }}</p>
        </div>
    </a>
    @endforeach
</div>

{{-- ===== GROOMER ===== --}}
@elseif(Auth::user()->rol?->nombre === 'groomer')

@php
    $groomer = Auth::user()->groomer;
    $citasHoy = $groomer
        ? \App\Models\Cita::where('groomer_id', $groomer->id)
            ->whereDate('fecha_hora_inicio', now())
            ->whereNotIn('estado', ['cancelada'])
            ->count()
        : 0;
    $completadasHoy = $groomer
        ? \App\Models\Cita::where('groomer_id', $groomer->id)
            ->whereDate('fecha_hora_inicio', now())
            ->where('estado', 'completada')
            ->count()
        : 0;
    $proximaCita = $groomer
        ? \App\Models\Cita::where('groomer_id', $groomer->id)
            ->whereDate('fecha_hora_inicio', now())
            ->whereNotIn('estado', ['cancelada', 'completada'])
            ->orderBy('fecha_hora_inicio')
            ->first()
        : null;
@endphp

{{-- Welcome card verde --}}
<div style="background:#1B5E20; border-radius:16px; padding:24px 28px; margin-bottom:20px; color:#fff; display:flex; align-items:center; gap:20px; position:relative; overflow:hidden;">
    <div style="position:absolute; right:-20px; top:-30px; width:160px; height:160px; border-radius:50%; background:rgba(255,255,255,0.05);"></div>
    <div style="position:absolute; right:40px; bottom:-50px; width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,0.04);"></div>
    <div style="width:56px; height:56px; border-radius:16px; background:rgba(255,255,255,0.12); display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; position:relative;">
        <i class="ti ti-scissors"></i>
    </div>
    <div style="position:relative;">
        <h2 style="font-size:18px; font-weight:700; margin:0 0 4px;">¡Hola, {{ Auth::user()->name }}!</h2>
        <p style="opacity:0.75; font-size:13px; margin:0;">Panel del groomer · Todo listo para hoy</p>
    </div>
</div>

{{-- Mini stats groomer --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin-bottom:20px;">
    <div style="background:#f5f5f0; border-radius:10px; padding:14px 16px;">
        <p style="font-size:12px; color:#6B8F6B; margin:0 0 6px; display:flex; align-items:center; gap:6px;">
            <i class="ti ti-calendar-check" style="font-size:14px;"></i> Citas hoy
        </p>
        <p style="font-size:22px; font-weight:700; color:#2E7D32; margin:0;">{{ $citasHoy }}</p>
    </div>
    <div style="background:#f5f5f0; border-radius:10px; padding:14px 16px;">
        <p style="font-size:12px; color:#6B8F6B; margin:0 0 6px; display:flex; align-items:center; gap:6px;">
            <i class="ti ti-clock" style="font-size:14px;"></i> Próxima cita
        </p>
        <p style="font-size:16px; font-weight:700; color:#1A2E1A; margin:0; line-height:1.6;">
            {{ $proximaCita ? \Carbon\Carbon::parse($proximaCita->fecha_hora_inicio)->format('h:i A') : '—' }}
        </p>
    </div>
    <div style="background:#f5f5f0; border-radius:10px; padding:14px 16px;">
        <p style="font-size:12px; color:#6B8F6B; margin:0 0 6px; display:flex; align-items:center; gap:6px;">
            <i class="ti ti-circle-check" style="font-size:14px;"></i> Completadas
        </p>
        <p style="font-size:22px; font-weight:700; color:#1A2E1A; margin:0;">{{ $completadasHoy }}</p>
    </div>
</div>

{{-- Action cards groomer --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:14px;">
    <a href="{{ route('groomer.agenda.index') }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:16px; padding:20px;">
        <div style="width:46px; height:46px; border-radius:12px; background:#EAF3DE; display:flex; align-items:center; justify-content:center; font-size:22px; color:#3B6D11; flex-shrink:0;">
            <i class="ti ti-calendar-event"></i>
        </div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#1A2E1A; margin:0 0 3px;">Mi Agenda</p>
            <p style="font-size:12px; color:#6B8F6B; margin:0;">Citas del día</p>
        </div>
        <i class="ti ti-chevron-right" style="margin-left:auto; color:#aaa; font-size:18px;"></i>
    </a>
    <a href="{{ route('password.cambiar') }}" class="stat-card" style="text-decoration:none; display:flex; align-items:center; gap:16px; padding:20px;">
        <div style="width:46px; height:46px; border-radius:12px; background:#FAEEDA; display:flex; align-items:center; justify-content:center; font-size:22px; color:#854F0B; flex-shrink:0;">
            <i class="ti ti-lock"></i>
        </div>
        <div>
            <p style="font-size:14px; font-weight:700; color:#1A2E1A; margin:0 0 3px;">Mi cuenta</p>
            <p style="font-size:12px; color:#6B8F6B; margin:0;">Cambiar contraseña</p>
        </div>
        <i class="ti ti-chevron-right" style="margin-left:auto; color:#aaa; font-size:18px;"></i>
    </a>
</div>

@endif

@endsection
