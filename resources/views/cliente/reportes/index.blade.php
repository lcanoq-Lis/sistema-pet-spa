@extends('layouts.dashboard')

@section('page-title', 'Mi Historial')
@section('page-subtitle', 'Tus citas, mascotas y puntos acumulados')

@section('content')

{{-- KPIs --}}
<div class="grid grid-cols-[repeat(auto-fill,minmax(200px,1fr))] gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="text-3xl mb-2">✅</div>
        <div class="text-3xl font-extrabold text-green-700">{{ $totalCitas }}</div>
        <div class="text-xs font-semibold text-stone-400 mt-1">Citas completadas</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="text-3xl mb-2">💰</div>
        <div class="text-3xl font-extrabold text-green-700">Bs. {{ number_format($totalGastado, 2) }}</div>
        <div class="text-xs font-semibold text-stone-400 mt-1">Total invertido</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="text-3xl mb-2">⭐</div>
        <div class="text-3xl font-extrabold text-amber-600">{{ number_format($puntosTotales) }}</div>
        <div class="text-xs font-semibold text-stone-400 mt-1">Puntos acumulados</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-200 p-6">
        <div class="text-3xl mb-2">✂️</div>
        <div class="text-base font-extrabold text-blue-700 truncate" title="{{ $servicioFavoritoNombre }}">{{ $servicioFavoritoNombre }}</div>
        <div class="text-xs font-semibold text-stone-400 mt-1">Servicio favorito</div>
    </div>
</div>
<div style="display:flex; justify-content:flex-end; gap:10px; margin-bottom:24px;">
    <a href="{{ route('cliente.reportes.pdf') }}"
        style="display:inline-flex; align-items:center; gap:6px; background:#C62828; color:#fff; font-weight:600; padding:10px 20px; border-radius:40px; text-decoration:none; font-size:13px;">
        <i class="ti ti-file-type-pdf" style="font-size:15px;"></i> Descargar PDF
    </a>
    <a href="{{ route('cliente.reportes.excel') }}"
        style="display:inline-flex; align-items:center; gap:6px; background:#1B5E20; color:#fff; font-weight:600; padding:10px 20px; border-radius:40px; text-decoration:none; font-size:13px;">
        <i class="ti ti-file-type-xls" style="font-size:15px;"></i> Descargar Excel
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Historial de citas --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-stone-100">
            <h3 class="text-sm font-bold text-stone-800 m-0">📋 Historial de citas</h3>
        </div>
        @if($historial->isEmpty())
            <div class="p-10 text-center text-stone-400 text-sm">Sin historial aún</div>
        @else
        <div class="max-h-[380px] overflow-y-auto divide-y divide-stone-100">
            @foreach($historial as $cita)
            <div class="p-4 px-6">
                <div class="flex justify-between items-center gap-4">
                    <div class="min-w-0">
                        <div class="font-semibold text-stone-800 text-sm truncate">
                            {{ $cita->mascota->nombre ?? '—' }} · {{ $cita->servicio->nombre ?? '—' }}
                        </div>
                        <div class="text-xs text-stone-400 mt-0.5">{{ $cita->fecha_hora_inicio?->format('d/m/Y H:i') }}</div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-[11px] font-bold px-2.5 py-1 rounded-full {{ $cita->estado === 'completada' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                            {{ ucfirst($cita->estado) }}
                        </span>
                        @if($cita->estado === 'completada')
                        <div class="text-xs font-bold text-green-700 mt-1">
                            Bs. {{ number_format($cita->pago?->total ?? $cita->precio_acordado, 2) }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Mascotas y vacunas --}}
    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
        <div class="p-5 border-b border-stone-100">
            <h3 class="text-sm font-bold text-stone-800 m-0">🐾 Mis mascotas</h3>
        </div>
        @if($mascotas->isEmpty())
            <div class="p-10 text-center text-stone-400 text-sm">Sin mascotas registradas</div>
        @else
        <div class="max-h-[380px] overflow-y-auto divide-y divide-stone-100">
            @foreach($mascotas as $mascota)
            <div class="p-4 px-6">
                <div class="flex items-center gap-3 mb-2.5">
                    @if($mascota->foto_url)
                        <img src="{{ $mascota->foto_url }}" class="w-11 h-11 rounded-full object-cover">
                    @else
                        <div class="w-11 h-11 bg-green-50 rounded-full flex items-center justify-center text-xl shrink-0">🐶</div>
                    @endif
                    <div class="min-w-0">
                        <div class="font-bold text-stone-800 text-sm truncate">{{ $mascota->nombre }}</div>
                        <div class="text-xs text-stone-400 truncate">{{ $mascota->raza ?? $mascota->especie }} · {{ $mascota->edad() }}</div>
                    </div>
                </div>
                {{-- Vacunas --}}
                @if($mascota->vacunas->isNotEmpty())
                <div class="pl-14">
                    <div class="text-[10px] font-bold text-stone-400 tracking-wider mb-1.5">💉 VACUNAS</div>
                    @foreach($mascota->vacunas->take(3) as $vacuna)
                    <div class="text-xs text-stone-600 mb-0.5">
                        · {{ $vacuna->nombre }} —
                        <span class="{{ $vacuna->fecha_proxima && $vacuna->fecha_proxima < now() ? 'text-red-700 font-medium' : 'text-green-700' }}">
                            {{ $vacuna->fecha_proxima ? $vacuna->fecha_proxima->format('d/m/Y') : 'Sin fecha próxima' }}
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>

</div>

{{-- Galería de evolución --}}
@if($evoluciones->isNotEmpty())
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden mb-6">
    <div class="p-5 border-b border-stone-100">
        <h3 class="text-sm font-bold text-stone-800 m-0">📸 Galería de evolución</h3>
    </div>
    <div class="p-5 grid grid-cols-[repeat(auto-fill,minmax(280px,1fr))] gap-4">
        @foreach($evoluciones as $evolucion)
        <div class="border border-stone-100 rounded-xl overflow-hidden shadow-sm">
            <div class="grid grid-cols-2">
                <div class="relative">
                    <img src="{{ asset('storage/' . $evolucion->foto_antes) }}" class="w-110% h-36 object-cover">
                    <span class="absolute bottom-1.5 left-1.5 bg-black/60 text-white text-[9px] font-bold px-2 py-0.5 rounded-full tracking-wider">ANTES</span>
                </div>
                <div class="relative">
                    <img src="{{ asset('storage/' . $evolucion->foto_despues) }}" class="w-110% h-36 object-cover">
                    <span class="absolute bottom-1.5 right-1.5 bg-green-700/80 text-white text-[9px] font-bold px-2 py-0.5 rounded-full tracking-wider">DESPUÉS</span>
                </div>
            </div>
            <div class="p-3">
                <div class="font-bold text-stone-800 text-xs truncate">{{ $evolucion->mascota->nombre }} — {{ $evolucion->titulo }}</div>
                <div class="text-[10px] text-stone-400 mt-0.5">{{ $evolucion->fecha->format('d/m/Y') }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Puntos --}}
@if($movimientosPuntos->isNotEmpty())
<div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
    <div class="p-5 border-b border-stone-100 flex justify-between items-center">
        <h3 class="text-sm font-bold text-stone-800 m-0">⭐ Mis puntos</h3>
        <span class="text-xl font-extrabold text-amber-600">{{ number_format($puntosTotales) }} pts</span>
    </div>
    <div class="divide-y divide-stone-100">
        @foreach($movimientosPuntos as $mov)
        <div class="p-3 px-6 flex justify-between items-center gap-4">
            <div>
                <div class="text-sm font-semibold text-stone-800">{{ $mov->concepto }}</div>
                <div class="text-[11px] text-stone-400 mt-0.5">{{ $mov->created_at->format('d/m/Y') }}</div>
            </div>
            <span class="text-base font-extrabold shrink-0 {{ $mov->puntos > 0 ? 'text-green-700' : 'text-red-700' }}">
                {{ $mov->puntos > 0 ? '+' : '' }}{{ $mov->puntos }}
            </span>
        </div>
        @endforeach
    </div>
</div>

{{-- Botones de Exportación --}}
<div class="flex items-center gap-2.5">
    <a href="{{ route('cliente.reportes.pdf', ['mes'=>$mes,'anio'=>$anio]) }}"
       class="inline-flex items-center gap-1.5 bg-[#C62828] text-white font-semibold px-5 py-2 rounded-full text-xs no-underline hover:bg-[#b02323] transition-colors">
        <i class="ti ti-file-type-pdf text-sm"></i> PDF
    </a>
    <a href="{{ route('cliente.reportes.excel', ['mes'=>$mes,'anio'=>$anio]) }}"
       class="inline-flex items-center gap-1.5 bg-[#1B5E20] text-white font-semibold px-5 py-2 rounded-full text-xs no-underline hover:bg-[#154a19] transition-colors">
        <i class="ti ti-file-type-xls text-sm"></i> Excel
    </a>
</div>
@endif

@endsection