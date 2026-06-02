@extends('layouts.dashboard')

@section('page-title', 'Nuevo Servicio')
@section('page-subtitle', 'Agrega un servicio al catálogo')

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

        <form method="POST" action="{{ route('admin.servicios.store') }}">
            @csrf

            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                    <i class="ti ti-tag" style="font-size:14px;"></i> Nombre del servicio *
                </label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                    style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; transition:all 0.2s;"
                    placeholder="Ej: Baño completo" required>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px;">
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-coin" style="font-size:14px;"></i> Precio base (Bs.) *
                    </label>
                    <input type="number" name="precio_base" value="{{ old('precio_base') }}" step="0.50" min="0"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none;"
                        required>
                </div>
                <div>
                    <label style="display:block; font-size:12px; font-weight:600; color:#5D4037; margin-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                        <i class="ti ti-clock" style="font-size:14px;"></i> Duración base (minutos) *
                    </label>
                    <select name="duracion_base_minutos"
                        style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; background:white;"
                        required>
                        <option value="">Selecciona...</option>
                        @foreach([15,30,45,60,90,120,150,180] as $min)
                            <option value="{{ $min }}" {{ old('duracion_base_minutos') == $min ? 'selected' : '' }}>
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
                    style="width:100%; border:2px solid #E0D6CC; border-radius:14px; padding:12px 16px; font-size:14px; outline:none; resize:vertical;"
                    placeholder="Descripción del servicio...">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Preview de precios por tamaño --}}
            <div style="background:#E8F5E9; border-radius:16px; padding:18px; margin-bottom:28px;">
                <p style="font-size:12px; font-weight:600; color:#2E7D32; margin-bottom:12px; display:flex; align-items:center; gap:8px;">
                    <i class="ti ti-chart-line" style="font-size:14px;"></i> Precios estimados por tamaño (automático):
                </p>
                <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:8px; text-align:center;">
                    @foreach(['XS'=>1.0,'S'=>1.0,'M'=>1.15,'L'=>1.30,'XL'=>1.50] as $tam => $factor)
                    <div style="background:white; border-radius:12px; padding:10px;">
                        <p style="font-size:11px; font-weight:700; color:#2E7D32; margin:0;">{{ $tam }}</p>
                        <p style="font-size:10px; color:#A1887F; margin:4px 0 0;">x{{ $factor }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div style="display:flex; gap:14px;">
                <a href="{{ route('admin.servicios.index') }}"
                    style="flex:1; text-align:center; background:#F5F0EB; color:#8D6E63; font-weight:600; padding:14px; border-radius:40px; text-decoration:none; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-arrow-left"></i> Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#2E7D32,#43A047); color:white; font-weight:700; padding:14px; border-radius:40px; border:none; cursor:pointer; font-size:13px; display:flex; align-items:center; justify-content:center; gap:8px; transition:all 0.2s;">
                    <i class="ti ti-device-floppy"></i> Guardar servicio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection