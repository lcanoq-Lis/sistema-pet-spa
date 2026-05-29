@extends('layouts.dashboard')
@section('page-title', '📆 Calendario Maestro')
@section('page-subtitle', 'Vista interactiva de citas — arrastra para reprogramar')

@section('content')

{{-- FullCalendar CSS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.css" rel="stylesheet">

{{-- Filtro por groomer --}}
<div style="display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; align-items:center;">
    <span style="font-size:13px; font-weight:600; color:var(--text-secondary);">Filtrar por groomer:</span>
    <a href="{{ route('recepcion.calendario', ['groomer' => 'todos']) }}"
        style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none;
               background:{{ $groomerFiltro === 'todos' ? 'var(--brand)' : 'var(--bg)' }};
               color:{{ $groomerFiltro === 'todos' ? 'white' : 'var(--text-primary)' }};
               border:1px solid {{ $groomerFiltro === 'todos' ? 'var(--brand)' : 'var(--border)' }};">
        👥 Todos
    </a>
    @foreach($groomers as $g)
    <a href="{{ route('recepcion.calendario', ['groomer' => $g->id]) }}"
        style="padding:6px 14px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none;
               background:{{ $groomerFiltro == $g->id ? 'var(--brand)' : 'var(--bg)' }};
               color:{{ $groomerFiltro == $g->id ? 'white' : 'var(--text-primary)' }};
               border:1px solid {{ $groomerFiltro == $g->id ? 'var(--brand)' : 'var(--border)' }};">
        ✂️ {{ $g->nombre }}
    </a>
    @endforeach
</div>

{{-- Alerta de reprogramación --}}
<div id="alerta-reprog" style="display:none; padding:10px 16px; border-radius:10px; font-size:13px; font-weight:500; margin-bottom:16px;"></div>

{{-- Calendario --}}
<div class="card" style="padding:20px;">
    <div id="calendar"></div>
</div>

{{-- Modal detalle cita --}}
<div id="modal-cita" onclick="cerrarModal()"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div onclick="event.stopPropagation()"
        style="background:white; border-radius:16px; padding:28px; max-width:380px; width:90%; box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="display:flex; justify-content:space-between; align-items:start; margin-bottom:16px;">
            <h3 id="modal-titulo" style="font-size:16px; font-weight:700; color:var(--text-primary); margin:0;"></h3>
            <button onclick="cerrarModal()" style="background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-muted);">✕</button>
        </div>
        <div style="display:flex; flex-direction:column; gap:8px; margin-bottom:20px;">
            <div style="background:var(--bg); border-radius:10px; padding:10px 14px;">
                <p style="font-size:11px; color:var(--text-muted); margin:0;">SERVICIO</p>
                <p id="modal-servicio" style="font-size:14px; font-weight:600; color:var(--text-primary); margin:2px 0 0;"></p>
            </div>
            <div style="background:var(--bg); border-radius:10px; padding:10px 14px;">
                <p style="font-size:11px; color:var(--text-muted); margin:0;">HORARIO</p>
                <p id="modal-hora" style="font-size:14px; font-weight:600; color:var(--text-primary); margin:2px 0 0;"></p>
            </div>
            <div style="background:var(--bg); border-radius:10px; padding:10px 14px;">
                <p style="font-size:11px; color:var(--text-muted); margin:0;">GROOMER</p>
                <p id="modal-groomer" style="font-size:14px; font-weight:600; color:var(--text-primary); margin:2px 0 0;"></p>
            </div>
            <div style="background:var(--bg); border-radius:10px; padding:10px 14px;">
                <p style="font-size:11px; color:var(--text-muted); margin:0;">ESTADO</p>
                <p id="modal-estado" style="font-size:14px; font-weight:600; color:var(--text-primary); margin:2px 0 0;"></p>
            </div>
        </div>
        <a href="{{ route('recepcion.citas.index') }}" class="btn btn-primary" style="width:100%; text-align:center; display:block;">
            Ver todas las citas →
        </a>
    </div>
</div>

{{-- FullCalendar JS --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/locales/es.global.min.js"></script>

<script>
const CSRF         = '{{ csrf_token() }}';
const GROOMER      = '{{ $groomerFiltro }}';
const EVENTOS_URL  = '{{ route("recepcion.calendario.eventos") }}';
const MOVER_URL    = '/recepcion/citas/{id}/mover';

document.addEventListener('DOMContentLoaded', function() {
    const calEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calEl, {
        locale: 'es',
        initialView: 'timeGridWeek',
        headerToolbar: {
            left:   'prev,next today',
            center: 'title',
            right:  'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotMinTime: '07:00:00',
        slotMaxTime: '20:00:00',
        slotDuration: '00:30:00',
        height: 'auto',
        nowIndicator: true,
        editable: true,
        eventDurationEditable: false,

        // Cargar eventos desde el servidor
        events: function(info, successCallback, failureCallback) {
            fetch(`${EVENTOS_URL}?start=${info.startStr}&end=${info.endStr}&groomer=${GROOMER}`)
                .then(r => r.json())
                .then(data => successCallback(data))
                .catch(() => failureCallback());
        },

        // Clic en evento — mostrar detalle
        eventClick: function(info) {
            const p = info.event.extendedProps;
            const start = info.event.start;
            const end   = info.event.end;
            document.getElementById('modal-titulo').textContent  = '🐾 ' + p.mascota;
            document.getElementById('modal-servicio').textContent = p.servicio;
            document.getElementById('modal-hora').textContent    =
                start.toLocaleTimeString('es', {hour:'2-digit',minute:'2-digit'}) + ' — ' +
                (end ? end.toLocaleTimeString('es', {hour:'2-digit',minute:'2-digit'}) : '');
            document.getElementById('modal-groomer').textContent = p.groomer;
            document.getElementById('modal-estado').textContent  = p.estado.replace('_',' ').toUpperCase();
            document.getElementById('modal-cita').style.display  = 'flex';
        },

        // Drag & drop — reprogramar
        eventDrop: function(info) {
            const id    = info.event.id;
            const start = info.event.start.toISOString();
            const end   = info.event.end ? info.event.end.toISOString() : null;

            fetch(MOVER_URL.replace('{id}', id), {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ start, end })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    mostrarAlerta('✅ ' + data.message, 'exito');
                } else {
                    mostrarAlerta('❌ ' + data.error, 'error');
                    info.revert();
                }
            })
            .catch(() => {
                mostrarAlerta('❌ Error de conexión.', 'error');
                info.revert();
            });
        },

        // Estilos personalizados
        eventDidMount: function(info) {
            info.el.style.borderRadius = '8px';
            info.el.style.fontSize     = '12px';
            info.el.style.fontWeight   = '600';
            info.el.style.cursor       = info.event.extendedProps.editable ? 'grab' : 'pointer';
        },

        buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día' },
    });

    calendar.render();
});

function mostrarAlerta(texto, tipo) {
    const el = document.getElementById('alerta-reprog');
    el.style.display    = 'block';
    el.style.background = tipo === 'exito' ? '#e8f5e9' : '#ffebee';
    el.style.color      = tipo === 'exito' ? '#2e7d32' : '#c62828';
    el.style.border     = tipo === 'exito' ? '1px solid #a5d6a7' : '1px solid #ffcdd2';
    el.textContent = texto;
    setTimeout(() => el.style.display = 'none', 4000);
}

function cerrarModal() {
    document.getElementById('modal-cita').style.display = 'none';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
</script>
@endsection
