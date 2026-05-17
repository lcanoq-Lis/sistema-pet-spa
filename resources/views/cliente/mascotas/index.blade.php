@extends('layouts.dashboard')

@section('page-title', '🐾 Mis Mascotas')
@section('page-subtitle', 'Administra el perfil de tus mascotas')

@section('content')

@if(session('status'))
    <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:16px;">
        ✅ {{ session('status') }}
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
    <h2 style="font-size:20px; font-weight:700; color:#5d4037;">Mis Mascotas</h2>
    <a href="{{ route('cliente.mascotas.create') }}"
        style="background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:10px 20px; border-radius:10px; text-decoration:none; font-size:14px;">
        + Agregar Mascota
    </a>
</div>

@if($mascotas->isEmpty())
    <div class="stat-card" style="text-align:center; padding:48px;">
        <div style="font-size:64px; margin-bottom:16px;">🐶</div>
        <h3 style="font-size:18px; font-weight:700; color:#5d4037;">No tienes mascotas registradas</h3>
        <p style="color:#a1887f; margin-top:8px; font-size:14px;">Agrega tu primera mascota para solicitar citas</p>
        <a href="{{ route('cliente.mascotas.create') }}"
            style="display:inline-block; margin-top:16px; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:600; padding:12px 24px; border-radius:10px; text-decoration:none;">
            Agregar primera mascota
        </a>
    </div>
@else
    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:16px;">
        @foreach($mascotas as $mascota)
        <div class="stat-card">
            {{-- Emoji según especie --}}
            <div style="font-size:48px; text-align:center; margin-bottom:12px;">
                @if($mascota->especie === 'perro') 🐶
                @elseif($mascota->especie === 'gato') 🐱
                @else 🐾
                @endif
            </div>

            <h3 style="font-size:18px; font-weight:700; color:#5d4037; text-align:center;">
                {{ $mascota->nombre }}
            </h3>

            <div style="margin-top:12px; space-y:8px;">
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f5f0eb;">
                    <span style="font-size:13px; color:#a1887f;">Especie</span>
                    <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ ucfirst($mascota->especie) }}</span>
                </div>
                @if($mascota->raza)
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f5f0eb;">
                    <span style="font-size:13px; color:#a1887f;">Raza</span>
                    <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $mascota->raza }}</span>
                </div>
                @endif
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f5f0eb;">
                    <span style="font-size:13px; color:#a1887f;">Tamaño</span>
                    <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ strtoupper($mascota->tamano) }}</span>
                </div>
                @if($mascota->peso_kg)
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f5f0eb;">
                    <span style="font-size:13px; color:#a1887f;">Peso</span>
                    <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $mascota->peso_kg }} kg</span>
                </div>
                @endif
                <div style="display:flex; justify-content:space-between; padding:6px 0; border-bottom:1px solid #f5f0eb;">
                    <span style="font-size:13px; color:#a1887f;">Edad</span>
                    <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ $mascota->edad() }}</span>
                </div>
                @if($mascota->temperamento)
                <div style="display:flex; justify-content:space-between; padding:6px 0;">
                    <span style="font-size:13px; color:#a1887f;">Temperamento</span>
                    <span style="font-size:13px; font-weight:600; color:#5d4037;">{{ ucfirst($mascota->temperamento) }}</span>
                </div>
                @endif
            </div>

            @if($mascota->alergias)
            <div style="background:#fff3e0; border-radius:8px; padding:8px 12px; margin-top:12px;">
                <p style="font-size:12px; color:#e65100; font-weight:600;">⚠️ Alergias:</p>
                <p style="font-size:12px; color:#bf360c;">{{ $mascota->alergias }}</p>
            </div>
            @endif

            <div style="display:flex; gap:8px; margin-top:16px;">
                <a href="{{ route('cliente.mascotas.edit', $mascota->id) }}"
                    style="flex:1; text-align:center; background:#fff3e0; color:#ff7043; font-weight:600; padding:8px; border-radius:8px; text-decoration:none; font-size:13px;">
                    ✏️ Editar
                </a>
                <form method="POST" action="{{ route('cliente.mascotas.destroy', $mascota->id) }}" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="button"
                        onclick="abrirModal(this.closest('form'), '{{ $mascota->nombre }}')"
                        style="width:100%; background:#ffebee; color:#c62828; font-weight:600; padding:8px; border-radius:8px; border:none; cursor:pointer; font-size:13px; font-family:Poppins,sans-serif;">
                        🗑️ Eliminar
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
@endif
{{-- Modal de confirmación --}}
<div id="modal-eliminar" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; border-radius:20px; padding:32px; max-width:380px; width:90%; text-align:center; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="font-size:56px; margin-bottom:16px;">🗑️</div>
        <h3 style="font-size:20px; font-weight:700; color:#5d4037; margin-bottom:8px;">¿Eliminar mascota?</h3>
        <p id="modal-texto" style="font-size:14px; color:#a1887f; margin-bottom:24px;"></p>
        <div style="display:flex; gap:12px;">
            <button onclick="cerrarModal()"
                style="flex:1; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                Cancelar
            </button>
            <button onclick="confirmarEliminar()"
                style="flex:1; background:linear-gradient(135deg,#ef5350,#e53935); color:white; font-weight:600; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                Sí, eliminar
            </button>
        </div>
    </div>
</div>

<script>
let formEliminar = null;

function abrirModal(form, nombre) {
    formEliminar = form;
    document.getElementById('modal-texto').textContent = '¿Estás segura de que quieres eliminar a ' + nombre + '? Esta acción no se puede deshacer.';
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
</script>
@endsection