@extends('layouts.dashboard')

@section('page-title', 'Mis Mascotas')
@section('page-subtitle', 'Administra el perfil de tus mascotas')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:36px; height:36px; background:linear-gradient(135deg, #FF7043, #F57F17); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-paw" style="font-size:18px; color:#fff;"></i>
        </div>
        <h2 style="font-size:18px; font-weight:700; color:#1A2E1A; margin:0;">Mis Mascotas</h2>
    </div>
    <a href="{{ route('cliente.mascotas.create') }}"
        style="background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:10px 24px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:8px;">
        <i class="ti ti-plus" style="font-size:14px;"></i> Agregar Mascota
    </a>
</div>

@if($mascotas->isEmpty())
    <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; text-align:center; padding:56px 24px;">
        <div style="width:72px; height:72px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-dog" style="font-size:32px; color:#8A9B8A;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:700; color:#1A2E1A;">No tienes mascotas registradas</h3>
        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Agrega tu primera mascota para solicitar citas</p>
        <a href="{{ route('cliente.mascotas.create') }}"
            style="display:inline-flex; align-items:center; gap:8px; margin-top:16px; background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:12px 28px; border-radius:40px; text-decoration:none;">
            <i class="ti ti-paw" style="font-size:14px;"></i> Agregar primera mascota
        </a>
    </div>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(320px, 1fr)); gap:20px;">
        @foreach($mascotas as $mascota)
        <div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow:hidden; transition:box-shadow 0.2s;">
            {{-- Header con icono y nombre --}}
            <div style="background:linear-gradient(135deg, #FF7043, #F57F17); padding:20px; text-align:center;">
                <div style="width:64px; height:64px; background:rgba(255,255,255,0.2); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                    @if($mascota->especie === 'perro')
                        <i class="ti ti-dog" style="font-size:32px; color:#fff;"></i>
                    @elseif($mascota->especie === 'gato')
                        <i class="ti ti-cat" style="font-size:32px; color:#fff;"></i>
                    @else
                        <i class="ti ti-paw" style="font-size:32px; color:#fff;"></i>
                    @endif
                </div>
                <h3 style="font-size:18px; font-weight:800; color:#fff; margin:0;">{{ $mascota->nombre }}</h3>
            </div>

            <div style="padding:20px;">
                <div style="margin-bottom:16px;">
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0F0EA;">
                        <span style="font-size:12px; color:#8A9B8A; display:flex; align-items:center; gap:4px;"><i class="ti ti-category" style="font-size:11px;"></i> Especie</span>
                        <span style="font-size:12px; font-weight:600; color:#1A2E1A;">{{ ucfirst($mascota->especie) }}</span>
                    </div>
                    @if($mascota->raza)
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0F0EA;">
                        <span style="font-size:12px; color:#8A9B8A; display:flex; align-items:center; gap:4px;"><i class="ti ti-heart" style="font-size:11px;"></i> Raza</span>
                        <span style="font-size:12px; font-weight:600; color:#1A2E1A;">{{ $mascota->raza }}</span>
                    </div>
                    @endif
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0F0EA;">
                        <span style="font-size:12px; color:#8A9B8A; display:flex; align-items:center; gap:4px;"><i class="ti ti-ruler" style="font-size:11px;"></i> Tamaño</span>
                        <span style="font-size:12px; font-weight:600; color:#1A2E1A;">{{ strtoupper($mascota->tamano) }}</span>
                    </div>
                    @if($mascota->peso_kg)
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0F0EA;">
                        <span style="font-size:12px; color:#8A9B8A; display:flex; align-items:center; gap:4px;"><i class="ti ti-weight" style="font-size:11px;"></i> Peso</span>
                        <span style="font-size:12px; font-weight:600; color:#1A2E1A;">{{ $mascota->peso_kg }} kg</span>
                    </div>
                    @endif
                    <div style="display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid #F0F0EA;">
                        <span style="font-size:12px; color:#8A9B8A; display:flex; align-items:center; gap:4px;"><i class="ti ti-cake" style="font-size:11px;"></i> Edad</span>
                        <span style="font-size:12px; font-weight:600; color:#1A2E1A;">{{ $mascota->edad() }}</span>
                    </div>
                    @if($mascota->temperamento)
                    <div style="display:flex; justify-content:space-between; padding:8px 0;">
                        <span style="font-size:12px; color:#8A9B8A; display:flex; align-items:center; gap:4px;"><i class="ti ti-mood-smile" style="font-size:11px;"></i> Temperamento</span>
                        <span style="font-size:12px; font-weight:600; color:#1A2E1A;">{{ ucfirst($mascota->temperamento) }}</span>
                    </div>
                    @endif
                </div>

                @if($mascota->alergias)
                <div style="background:#FFF8E1; border-radius:12px; padding:10px 14px; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                    <i class="ti ti-alert-triangle" style="font-size:14px; color:#F57F17;"></i>
                    <div>
                        <p style="font-size:11px; font-weight:700; color:#E65100; margin:0;">Alergias:</p>
                        <p style="font-size:11px; color:#BF360C; margin:2px 0 0;">{{ $mascota->alergias }}</p>
                    </div>
                </div>
                @endif

                {{-- Vacunas --}}
                <div style="margin-top:12px;">
                    <p style="font-size:11px; font-weight:700; color:#4A7A4A; margin-bottom:8px; display:flex; align-items:center; gap:4px;">
                        <i class="ti ti-vaccine" style="font-size:12px;"></i> Vacunas:
                    </p>
                    @if($mascota->vacunas->isEmpty())
                        <p style="font-size:11px; color:#8A9B8A;">Sin vacunas registradas.</p>
                    @else
                        @foreach($mascota->vacunas as $vacuna)
                        <div style="display:flex; justify-content:space-between; align-items:center; padding:6px 0; border-bottom:1px solid #F0F0EA;">
                            <span style="font-size:11px; color:#1A2E1A;">{{ $vacuna->nombre_vacuna }}</span>
                            <span style="font-size:10px; color:{{ $vacuna->estaVigente() ? '#2E7D32' : '#C62828' }}; font-weight:700; display:inline-flex; align-items:center; gap:3px;">
                                <i class="ti {{ $vacuna->estaVigente() ? 'ti-circle-check' : 'ti-alert-circle' }}" style="font-size:10px;"></i>
                                {{ $vacuna->estaVigente() ? 'Vigente' : 'Vencida' }}
                            </span>
                        </div>
                        @if($vacuna->observaciones)
                        <a href="{{ $vacuna->observaciones }}" target="_blank" style="font-size:10px; color:#1565C0; display:inline-flex; align-items:center; gap:3px; margin-top:2px;">
                            <i class="ti ti-file" style="font-size:10px;"></i> Ver archivo
                        </a>
                        @endif
                        @endforeach
                    @endif
                </div>

                {{-- Agregar vacuna --}}
                <div style="margin-top:12px; border-top:1px solid #F0F0EA; padding-top:12px;">
                    <button type="button" onclick="toggleVacuna({{ $mascota->id }})"
                        style="background:#E3F2FD; color:#1565C0; border:none; padding:6px 14px; border-radius:30px; font-size:11px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
                        <i class="ti ti-vaccine" style="font-size:11px;"></i> Agregar vacuna
                    </button>
                    <div id="form-vacuna-{{ $mascota->id }}" style="display:none; margin-top:12px;">
                        <form method="POST" action="{{ route('cliente.mascotas.vacuna', $mascota->id) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="nombre_vacuna" placeholder="Nombre de la vacuna" required
                                style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:10px 12px; font-size:12px; outline:none; background:#FAFBF7; margin-bottom:8px;"
                                onfocus="this.style.borderColor='#1565C0'"
                                onblur="this.style.borderColor='#e0e0e0'">
                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-bottom:8px;">
                                <div>
                                    <label style="font-size:10px; color:#5D6E5D; font-weight:600;">Fecha aplicación</label>
                                    <input type="date" name="fecha_aplicacion"
                                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:8px 10px; font-size:12px; outline:none;">
                                </div>
                                <div>
                                    <label style="font-size:10px; color:#5D6E5D; font-weight:600;">Fecha vencimiento</label>
                                    <input type="date" name="fecha_vencimiento"
                                        style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:8px 10px; font-size:12px; outline:none;">
                                </div>
                            </div>
                            <input type="file" name="archivo" accept=".pdf,.jpg,.jpeg,.png"
                                style="width:100%; border:1.5px solid #e0e0e0; border-radius:10px; padding:8px 10px; font-size:11px; margin-bottom:8px;">
                            <p style="font-size:9px; color:#8A9B8A; margin-bottom:8px;">PDF, JPG o PNG — máx 5MB</p>
                            <button type="submit"
                                style="width:100%; background:linear-gradient(135deg, #1565C0, #0D47A1); color:#fff; font-weight:600; padding:8px; border-radius:10px; border:none; cursor:pointer; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                                <i class="ti ti-vaccine" style="font-size:12px;"></i> Guardar vacuna
                            </button>
                        </form>
                    </div>
                </div>

                <div style="display:flex; gap:10px; margin-top:16px;">
                    <a href="{{ route('cliente.mascotas.edit', $mascota->id) }}"
                        style="flex:1; text-align:center; background:#FFF8E1; color:#F57F17; font-weight:600; padding:10px; border-radius:12px; text-decoration:none; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                        <i class="ti ti-edit" style="font-size:12px;"></i> Editar
                    </a>
                    <form method="POST" action="{{ route('cliente.mascotas.destroy', $mascota->id) }}" style="flex:1;">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                            onclick="abrirModal(this.closest('form'), '{{ $mascota->nombre }}')"
                            style="width:100%; background:#FFEBEE; color:#C62828; font-weight:600; padding:10px; border-radius:12px; border:none; cursor:pointer; font-size:12px; display:inline-flex; align-items:center; justify-content:center; gap:4px;">
                            <i class="ti ti-trash" style="font-size:12px;"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

{{-- Modal de confirmación --}}
<div id="modal-eliminar" style="display:none; position:fixed; inset:0; background:rgba(26,46,26,0.5); backdrop-filter:blur(4px); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:#fff; border-radius:24px; padding:32px; max-width:400px; width:90%; text-align:center; box-shadow:0 20px 35px -10px rgba(0,0,0,0.15); border:0.5px solid #e0e0e0;">
        <div style="width:64px; height:64px; background:#FFEBEE; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
            <i class="ti ti-alert-triangle" style="font-size:32px; color:#C62828;"></i>
        </div>
        <h3 style="font-size:18px; font-weight:800; color:#1A2E1A; margin-bottom:8px;">¿Eliminar mascota?</h3>
        <p id="modal-texto" style="font-size:13px; color:#8A9B8A; margin-bottom:24px;"></p>
        <div style="display:flex; gap:12px;">
            <button onclick="cerrarModal()"
                style="flex:1; background:#fff; border:1.5px solid #e0e0e0; border-radius:14px; padding:12px; font-weight:600; color:#5D6E5D; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                <i class="ti ti-x" style="font-size:13px;"></i> Cancelar
            </button>
            <button onclick="confirmarEliminar()"
                style="flex:1; background:linear-gradient(135deg, #EF5350, #C62828); border:none; border-radius:14px; padding:12px; font-weight:700; color:#fff; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; gap:6px;">
                <i class="ti ti-trash" style="font-size:13px;"></i> Sí, eliminar
            </button>
        </div>
    </div>
</div>

<script>
let formEliminar = null;

function abrirModal(form, nombre) {
    formEliminar = form;
    document.getElementById('modal-texto').textContent = '¿Estás seguro de que quieres eliminar a ' + nombre + '? Esta acción no se puede deshacer.';
    const modal = document.getElementById('modal-eliminar');
    modal.style.display = 'flex';
}

function cerrarModal() {
    document.getElementById('modal-eliminar').style.display = 'none';
    formEliminar = null;
}

function confirmarEliminar() {
    if (formEliminar) formEliminar.submit();
}

function toggleVacuna(id) {
    const div = document.getElementById('form-vacuna-' + id);
    div.style.display = div.style.display === 'none' ? 'block' : 'none';
}
</script>
@endsection