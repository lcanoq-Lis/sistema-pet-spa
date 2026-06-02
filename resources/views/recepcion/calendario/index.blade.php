@extends('layouts.dashboard')
@section('page-title', 'Calendario Maestro')
@section('page-subtitle', 'Vista interactiva de citas — arrastra para reprogramar')

@section('content')

{{-- FullCalendar CSS --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.11/index.global.min.css" rel="stylesheet">

{{-- Filtro por groomer --}}
<div style="display:flex; gap:10px; margin-bottom:24px; flex-wrap:wrap; align-items:center;">
    <div style="display:flex; align-items:center; gap:6px;">
        <i class="ti ti-filter" style="font-size:14px; color:#6B8F6B;"></i>
        <span style="font-size:12px; font-weight:600; color:#5D6E5D;">Filtrar por groomer:</span>
    </div>
    <a href="{{ route('recepcion.calendario', ['groomer' => 'todos']) }}"
        style="padding:6px 16px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s;
               background:{{ $groomerFiltro === 'todos' ? '#1B5E20' : '#fff' }};
               color:{{ $groomerFiltro === 'todos' ? '#fff' : '#5D6E5D' }};
               border:1px solid {{ $groomerFiltro === 'todos' ? '#1B5E20' : '#e0e0e0' }};
               display:inline-flex; align-items:center; gap:5px;">
        <i class="ti ti-users" style="font-size:12px;"></i> Todos
    </a>
    @foreach($groomers as $g)
    <a href="{{ route('recepcion.calendario', ['groomer' => $g->id]) }}"
        style="padding:6px 16px; border-radius:20px; font-size:12px; font-weight:600; text-decoration:none; transition:all 0.2s;
               background:{{ $groomerFiltro == $g->id ? '#1B5E20' : '#fff' }};
               color:{{ $groomerFiltro == $g->id ? '#fff' : '#5D6E5D' }};
               border:1px solid {{ $groomerFiltro == $g->id ? '#1B5E20' : '#e0e0e0' }};
               display:inline-flex; align-items:center; gap:5px;">
        <i class="ti ti-scissors" style="font-size:12px;"></i> {{ $g->nombre }}
    </a>
    @endforeach
</div>

{{-- Alerta de reprogramación --}}
<div id="alerta-reprog" style="display:none; padding:12px 18px; border-radius:12px; font-size:13px; font-weight:500; margin-bottom:20px;"></div>

{{-- Calendario --}}
<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div id="calendar"></div>
</div>

{{-- Modal detalle cita --}}
<div id="modal-cita" onclick="cerrarModal()"
    style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(4px);">
    <div onclick="event.stopPropagation()"
        style="background:#fff; border-radius:24px; padding:28px; max-width:380px; width:90%; box-shadow:0 20px 35px -10px rgba(0,0,0,0.2); border:0.5px solid #e0e0e0;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <div style="display:flex; align-items:center; gap:8px;">
                <div style="width:32px; height:32px; background:linear-gradient(135deg, #1B5E20, #0D3B0D); border-radius:10px; display:flex; align-items:center; justify-content:center;">
                    <i class="ti ti-calendar-event" style="color:#fff; font-size:16px;"></i>
                </div>
                <h3 id="modal-titulo" style="font-size:16px; font-weight:800; color:#1A2E1A; margin:0;"></h3>
            </div>
            <button onclick="cerrarModal()" style="background:#F5F5F0; border:none; width:28px; height:28px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.2s;">
                <i class="ti ti-x" style="font-size:14px; color:#8A9B8A;"></i>
            </button>
        </div>
        <div style="display:flex; flex-direction:column; gap:10px; margin-bottom:24px;">
            <div style="background:#F9FBF6; border-radius:14px; padding:12px 16px; border:1px solid #E0E5D9;">
                <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">
                    <i class="ti ti-paw" style="font-size:10px;"></i> SERVICIO
                </p>
                <p id="modal-servicio" style="font-size:14px; font-weight:600; color:#1A2E1A; margin:0;"></p>
            </div>
            <div style="background:#F9FBF6; border-radius:14px; padding:12px 16px; border:1px solid #E0E5D9;">
                <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">
                    <i class="ti ti-clock" style="font-size:10px;"></i> HORARIO
                </p>
                <p id="modal-hora" style="font-size:14px; font-weight:600; color:#1A2E1A; margin:0;"></p>
            </div>
            <div style="background:#F9FBF6; border-radius:14px; padding:12px 16px; border:1px solid #E0E5D9;">
                <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">
                    <i class="ti ti-scissors" style="font-size:10px;"></i> GROOMER
                </p>
                <p id="modal-groomer" style="font-size:14px; font-weight:600; color:#1A2E1A; margin:0;"></p>
            </div>
            <div style="background:#F9FBF6; border-radius:14px; padding:12px 16px; border:1px solid #E0E5D9;">
                <p style="font-size:10px; font-weight:700; color:#4A7A4A; text-transform:uppercase; letter-spacing:0.5px; margin:0 0 4px;">
                    <i class="ti ti-info-circle" style="font-size:10px;"></i> ESTADO
                </p>
                <p id="modal-estado" style="font-size:14px; font-weight:600; margin:0;"></p>
            </div>
        </div>
        <a href="{{ route('recepcion.citas.index') }}" style="background:#1B5E20; border:none; border-radius:14px; padding:12px 20px; font-size:13px; font-weight:700; color:#fff; text-decoration:none; display:flex; align-items:center; justify-content:center; gap:8px; text-align:center; transition:all 0.2s;">
            <i class="ti ti-list" style="font-size:14px;"></i> Ver todas las citas
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

        events: function(info, successCallback, failureCallback) {
            fetch(`${EVENTOS_URL}?start=${info.startStr}&end=${info.endStr}&groomer=${GROOMER}`)
                .then(r => r.json())
                .then(data => successCallback(data))
                .catch(() => failureCallback());
        },

        eventClick: function(info) {
            const p = info.event.extendedProps;
            const start = info.event.start;
            const end   = info.event.end;
            
            const estadoText = p.estado.replace(/_/g, ' ').toUpperCase();
            let estadoColor = '';
            switch(p.estado) {
                case 'agendada': estadoColor = '#F57F17'; break;
                case 'confirmada': estadoColor = '#2E7D32'; break;
                case 'en_progreso': estadoColor = '#1565C0'; break;
                case 'completada': estadoColor = '#6A1B9A'; break;
                default: estadoColor = '#8A9B8A';
            }
            
            document.getElementById('modal-titulo').textContent = p.mascota;
            document.getElementById('modal-servicio').textContent = p.servicio;
            document.getElementById('modal-hora').textContent =
                start.toLocaleTimeString('es', {hour:'2-digit',minute:'2-digit'}) + ' — ' +
                (end ? end.toLocaleTimeString('es', {hour:'2-digit',minute:'2-digit'}) : '');
            document.getElementById('modal-groomer').textContent = p.groomer;
            document.getElementById('modal-estado').innerHTML = `<span style="color:${estadoColor}; display:inline-flex; align-items:center; gap:4px;"><i class="ti ti-circle-filled" style="font-size:8px;"></i> ${estadoText}</span>`;
            document.getElementById('modal-cita').style.display  = 'flex';
        },

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
                    mostrarAlerta(data.message, 'exito');
                } else {
                    mostrarAlerta(data.error, 'error');
                    info.revert();
                }
            })
            .catch(() => {
                mostrarAlerta('Error de conexión.', 'error');
                info.revert();
            });
        },

        eventDidMount: function(info) {
            const estado = info.event.extendedProps.estado;
            let bgColor = '';
            switch(estado) {
                case 'agendada': bgColor = '#FFF3E0'; break;
                case 'confirmada': bgColor = '#E8F5E9'; break;
                case 'en_progreso': bgColor = '#E3F2FD'; break;
                case 'completada': bgColor = '#F3E5F5'; break;
                default: bgColor = '#F5F5F0';
            }
            
            info.el.style.backgroundColor = bgColor;
            info.el.style.border = 'none';
            info.el.style.borderLeft = `4px solid ${bgColor === '#FFF3E0' ? '#F57F17' : bgColor === '#E8F5E9' ? '#2E7D32' : bgColor === '#E3F2FD' ? '#1565C0' : '#6A1B9A'}`;
            info.el.style.borderRadius = '10px';
            info.el.style.fontSize = '11px';
            info.el.style.fontWeight = '600';
            info.el.style.cursor = info.event.extendedProps.editable ? 'grab' : 'pointer';
            info.el.style.padding = '4px 6px';
            info.el.style.margin = '2px 0';
        },

        buttonText: { today: 'Hoy', month: 'Mes', week: 'Semana', day: 'Día' },
    });

    calendar.render();
});

function mostrarAlerta(texto, tipo) {
    const el = document.getElementById('alerta-reprog');
    el.style.display = 'block';
    el.style.background = tipo === 'exito' ? '#E8F5E9' : '#FFEBEE';
    el.style.color = tipo === 'exito' ? '#2E7D32' : '#C62828';
    el.style.border = tipo === 'exito' ? '1px solid #A5D6A7' : '1px solid #FFCDD2';
    el.style.display = 'flex';
    el.style.alignItems = 'center';
    el.style.gap = '8px';
    el.innerHTML = `<i class="ti ${tipo === 'exito' ? 'ti-circle-check' : 'ti-alert-circle'}" style="font-size:16px;"></i> ${texto}`;
    setTimeout(() => el.style.display = 'none', 4000);
}

function cerrarModal() {
    document.getElementById('modal-cita').style.display = 'none';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') cerrarModal(); });
</script>
@endsection