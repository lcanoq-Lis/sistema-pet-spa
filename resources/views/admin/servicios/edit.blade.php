@extends('layouts.dashboard')

@section('page-title', 'Editar Servicio')
@section('page-subtitle', 'Actualiza el precio y duración del servicio')

@section('content')
<div style="max-width:700px; margin:0 auto;">
    <div class="stat-card" style="border-radius:24px; padding:28px;">

        @if($errors->any())
            <div style="background:#FFF3E0; color:#E65100; border-left:4px solid #FF7043; padding:14px 18px; border-radius:12px; margin-bottom:24px; font-size:13px; display:flex; align-items:center; gap:10px;">
                <i class="ti ti-alert-circle" style="font-size:18px;"></i>
                <ul style="margin:0; padding-left:20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.servicios.update', $servicio->id) }}">
            @csrf
            @method('PUT')

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                    <i class="ti ti-tag" style="font-size:14px;"></i> Nombre *
                </label>
                <input type="text" name="nombre" value="{{ old('nombre', $servicio->nombre) }}"
                    style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                    required>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-coin" style="font-size:14px;"></i> Precio base (Bs.) *
                    </label>
                    <input type="number" name="precio_base" value="{{ old('precio_base', $servicio->precio_base) }}" step="0.50" min="0"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-clock" style="font-size:14px;"></i> Duración (minutos) *
                    </label>
                    <select name="duracion_base_minutos"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; background:white;"
                        required>
                        @foreach([15,30,45,60,90,120,150,180] as $min)
                            <option value="{{ $min }}" {{ $servicio->duracion_base_minutos == $min ? 'selected' : '' }}>
                                {{ $min }} minutos
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                    <i class="ti ti-notes" style="font-size:14px;"></i> Descripción
                </label>
                <textarea name="descripcion" rows="3"
                    style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; resize:vertical;">{{ old('descripcion', $servicio->descripcion) }}</textarea>
            </div>

            <div style="margin-bottom:28px;">
                <label style="display:flex; align-items:center; gap:10px; cursor:pointer;">
                    <input type="checkbox" name="activo" {{ $servicio->activo ? 'checked' : '' }}
                        style="width:18px; height:18px; accent-color:#2E7D32;">
                    <span style="font-size:13px; font-weight:600; color:#5D4037; display:flex; align-items:center; gap:6px;">
                        <i class="ti ti-circle-check"></i> Servicio activo
                    </span>
                </label>
            </div>

            <div style="display:flex; gap:14px;">
                <a href="{{ route('admin.servicios.index') }}"
                    style="flex:1; text-align:center; background:#F5F0EB; color:#8D6E63; font-weight:600; padding:14px; border-radius:40px; text-decoration:none; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-arrow-left"></i> Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:700; padding:14px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-device-floppy"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection