@extends('layouts.dashboard')

@section('page-title', '📅 Gestión de Citas')
@section('page-subtitle', 'Administra todas las citas del spa')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

{{-- Filtros de estado --}}
<div style="display:flex; gap:8px; margin-bottom:24px; flex-wrap:wrap;">
    @php
        $estados = [
            'todas'       => ['label'=>'Todas',        'color'=>'#5d4037'],
            'agendada'    => ['label'=>'⏳ Agendadas',  'color'=>'#e65100'],
            'confirmada'  => ['label'=>'✅ Confirmadas','color'=>'#2e7d32'],
            'en_progreso' => ['label'=>'🔄 En progreso','color'=>'#1565c0'],
            'completada'  => ['label'=>'🎉 Completadas','color'=>'#6a1b9a'],
            'cancelada'   => ['label'=>'❌ Canceladas', 'color'=>'#c62828'],
            'en_revision' => ['label'=>'🔍 En revisión', 'color'=>'#6a1b9a'],
        ];
        $filtro = request('estado', 'todas');
    @endphp

    @foreach($estados as $key => $est)
    <a href="{{ route('recepcion.citas.index', ['estado' => $key]) }}"
        style="padding:8px 16px; border-radius:20px; font-size:13px; font-weight:600; text-decoration:none;
               background:{{ $filtro === $key ? $est['color'] : '#f5f0eb' }};
               color:{{ $filtro === $key ? 'white' : $est['color'] }};">
        {{ $est['label'] }}
    </a>
    @endforeach
</div>

{{-- Tabla de citas --}}
<div class="stat-card" style="padding:0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:linear-gradient(135deg,#ff7043,#ff8f00);">
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Mascota / Cliente</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Servicio</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Fecha y Hora</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Groomer</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Estado</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $citasFiltradas = $filtro === 'todas' ? $citas : $citas->where('estado', $filtro);
            @endphp

            @forelse($citasFiltradas as $cita)
            <tr style="border-bottom:1px solid #f5f0eb; {{ $loop->even ? 'background:#fafafa;' : '' }}">
                <td style="padding:14px 16px;">
                    <p style="font-weight:700; color:#5d4037; font-size:14px;">{{ $cita->mascota->nombre }}</p>
                    <p style="font-size:12px; color:#a1887f;">{{ $cita->creadoPor?->name ?? 'Sin cliente' }}</p>
                </td>
                <td style="padding:14px 16px;">
                    <p style="font-size:13px; color:#5d4037;">{{ $cita->servicio->nombre }}</p>
                    <p style="font-size:12px; color:#a1887f;">Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
                </td>
                <td style="padding:14px 16px;">
                    <p style="font-size:13px; color:#5d4037; font-weight:600;">{{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
                    <p style="font-size:12px; color:#a1887f;">{{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}</p>
                </td>
                <td style="padding:14px 16px;">
                    <p style="font-size:13px; color:#5d4037;">{{ $cita->groomer?->nombre ?? 'Sin asignar' }}</p>
                </td>
                <td style="padding:14px 16px;">
                    @php
                        $colores = [
                            'agendada'    => ['bg'=>'#fff3e0', 'color'=>'#e65100', 'label'=>'⏳ Agendada'],
                            'confirmada'  => ['bg'=>'#e8f5e9', 'color'=>'#2e7d32', 'label'=>'✅ Confirmada'],
                            'en_progreso' => ['bg'=>'#e3f2fd', 'color'=>'#1565c0', 'label'=>'🔄 En progreso'],
                            'completada'  => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🎉 Completada'],
                            'cancelada'   => ['bg'=>'#ffebee', 'color'=>'#c62828', 'label'=>'❌ Cancelada'],
                            'no_asistio'  => ['bg'=>'#fafafa', 'color'=>'#757575', 'label'=>'😔 No asistió'],
                            'en_revision' => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🔍 En revisión'],
                        ];
                        $c = $colores[$cita->estado] ?? ['bg'=>'#f5f5f5', 'color'=>'#333', 'label'=>$cita->estado];
                    @endphp
                    <span style="background:{{ $c['bg'] }}; color:{{ $c['color'] }}; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                        {{ $c['label'] }}
                    </span>
                </td>
                
                <td style="padding:14px 16px;">
                    <div style="display:flex; gap:6px; flex-wrap:wrap;">
                        @if($cita->estado === 'agendada')
                        <form method="POST" action="{{ route('recepcion.citas.confirmar', $cita->id) }}">
                            @csrf
                            <button type="submit" style="background:#e8f5e9; color:#2e7d32; border:none; padding:6px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                                ✅ Confirmar
                            </button>
                        </form>
                        @endif
                        @if($cita->estado === 'en_revision')
                        <form method="POST" action="{{ route('recepcion.citas.confirmar', $cita->id) }}">
                            @csrf
                            <button type="submit" style="background:#e8f5e9; color:#2e7d32; border:none; padding:6px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                                ✅ Confirmar
                            </button>
                        </form>
                        @endif

                        @if($cita->estado === 'confirmada')
                        <form method="POST" action="{{ route('recepcion.citas.iniciar', $cita->id) }}">
                            @csrf
                            <button type="submit" style="background:#e3f2fd; color:#1565c0; border:none; padding:6px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                                🔄 Iniciar
                            </button>
                        </form>
                        @endif

                        @if($cita->estado === 'en_progreso')
                        <form method="POST" action="{{ route('recepcion.citas.completar', $cita->id) }}">
                            @csrf
                            <button type="submit" style="background:#f3e5f5; color:#6a1b9a; border:none; padding:6px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                                🎉 Completar
                            </button>
                        </form>
                        @endif

                        {{-- Botón Reprogramar (Agregado aquí junto a las demás acciones) --}}
                        @if(!in_array($cita->estado, ['cancelada', 'completada']))
                        <button type="button"
                            onclick="abrirModalReprogramar({{ $cita->id }}, '{{ $cita->fecha_hora_inicio->format('Y-m-d') }}', '{{ $cita->fecha_hora_inicio->format('H:i') }}')"
                            style="background:#e2f1e4; color:#1b5e20; border:none; padding:6px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                            📅 Reprogramar
                        </button>
                        @endif

                        @if(!in_array($cita->estado, ['cancelada', 'completada']))
                        <button type="button"
                            onclick="abrirModalCancelar({{ $cita->id }})"
                            style="background:#ffebee; color:#c62828; border:none; padding:6px 10px; border-radius:6px; font-size:11px; font-weight:600; cursor:pointer; font-family:Poppins,sans-serif;">
                            ❌ Cancelar
                        </button>
                        @endif

                        @if($cita->estado === 'completada' && !$cita->pago)
                        <a href="{{ route('recepcion.pagos.create', $cita->id) }}"
                            style="padding:6px 10px; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none;">
                            💳 Pago
                        </a>
                        @elseif($cita->pago)
                        <a href="{{ route('recepcion.pagos.factura', $cita->pago->id) }}"
                            style="padding:6px 10px; background:#e8f5e9; color:#2e7d32; border-radius:6px; font-size:11px; font-weight:600; text-decoration:none;">
                            🧾 Factura
                        </a>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:48px; text-align:center; color:#a1887f; font-size:14px;">
                    <div style="font-size:48px; margin-bottom:12px;">📅</div>
                    No hay citas para mostrar.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal cancelar --}}
<div id="modal-cancelar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:400px; width:90%; text-align:center;">
        <div style="font-size:48px; margin-bottom:16px;">❌</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:8px;">Cancelar cita</h3>
        <form id="form-cancelar" method="POST">
            @csrf
            <textarea name="motivo" rows="3" placeholder="Motivo de cancelación (opcional)"
                style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px; font-size:13px; font-family:Poppins,sans-serif; margin-bottom:16px; resize:none; outline:none;"></textarea>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalCancelar()"
                    style="flex:1; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Volver
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg,#ef5350,#e53935); color:white; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Cancelar cita
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal reprogramar (Agregado debajo del modal cancelar) --}}
<div id="modal-reprogramar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:400px; width:90%; text-align:center;">
        <div style="font-size:48px; margin-bottom:16px;">📅</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037; margin-bottom:16px;">Reprogramar cita</h3>
        <form id="form-reprogramar" method="POST">
            @csrf
            <div style="margin-bottom:12px; text-align:left;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nueva fecha</label>
                <input type="date" name="fecha" id="reprogramar-fecha"
                    min="{{ now()->format('Y-m-d') }}"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
            </div>
            <div style="margin-bottom:20px; text-align:left;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nueva hora</label>
                <select name="hora" id="reprogramar-hora"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;">
                    @for($h = 9; $h <= 17; $h++)
                        @foreach(['00', '30'] as $m)
                            @php $hora = sprintf('%02d:%s', $h, $m); @endphp
                            <option value="{{ $hora }}">{{ $hora }}</option>
                        @endforeach
                    @endfor
                </select>
            </div>
            <div style="display:flex; gap:12px;">
                <button type="button" onclick="cerrarModalReprogramar()"
                    style="flex:1; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Cancelar
                </button>
                <button type="submit"
                    style="flex:1; background:linear-gradient(135deg,#43a047,#66bb6a); color:white; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-family:Poppins,sans-serif;">
                    Reprogramar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Funciones para Cancelar
function abrirModalCancelar(id) {
    document.getElementById('form-cancelar').action = '/recepcion/citas/' + id + '/cancelar';
    document.getElementById('modal-cancelar').style.display = 'flex';
}
function cerrarModalCancelar() {
    document.getElementById('modal-cancelar').style.display = 'none';
}

// Funciones para Reprogramar (Agregadas aquí)
function abrirModalReprogramar(id, fecha, hora) {
    document.getElementById('form-reprogramar').action = '/recepcion/citas/' + id + '/reprogramar';
    document.getElementById('reprogramar-fecha').value = fecha;
    document.getElementById('reprogramar-hora').value  = hora;
    document.getElementById('modal-reprogramar').style.display = 'flex';
}
function cerrarModalReprogramar() {
    document.getElementById('modal-reprogramar').style.display = 'none';
}
</script>

@endsection