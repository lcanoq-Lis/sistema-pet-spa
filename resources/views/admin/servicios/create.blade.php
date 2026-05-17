@extends('layouts.dashboard')

@section('page-title', '➕ Nuevo Servicio')
@section('page-subtitle', 'Agrega un servicio al catálogo')

@section('content')
<div style="max-width:600px; margin:0 auto;">
    <div class="stat-card">

        @if($errors->any())
            <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
                <ul style="margin:0; padding-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.servicios.store') }}">
            @csrf

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nombre del servicio *</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                    placeholder="Ej: Baño completo" required>
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-bottom:16px;">
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Precio base (Bs.) *</label>
                    <input type="number" name="precio_base" value="{{ old('precio_base') }}" step="0.50" min="0"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>
                <div>
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Duración base (minutos) *</label>
                    <select name="duracion_base_minutos"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
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

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Descripción</label>
                <textarea name="descripcion" rows="3"
                    style="width:100%; border:2px solid #d7ccc8; border-radius:10px; padding:10px 14px; font-size:14px; outline:none; font-family:Poppins,sans-serif; resize:vertical;"
                    placeholder="Descripción del servicio...">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Preview de precios por tamaño --}}
            <div style="background:#f5f0eb; border-radius:12px; padding:16px; margin-bottom:24px;">
                <p style="font-size:13px; font-weight:600; color:#5d4037; margin-bottom:12px;">💰 Precios estimados por tamaño (automático):</p>
                <div style="display:grid; grid-template-columns:repeat(5,1fr); gap:8px; text-align:center;">
                    @foreach(['XS'=>1.0,'S'=>1.0,'M'=>1.15,'L'=>1.30,'XL'=>1.50] as $tam => $factor)
                    <div style="background:white; border-radius:8px; padding:8px;">
                        <p style="font-size:11px; font-weight:700; color:#ff7043;">{{ $tam }}</p>
                        <p style="font-size:11px; color:#a1887f;">x{{ $factor }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <div style="display:flex; gap:12px;">
                <a href="{{ route('admin.servicios.index') }}"
                    style="flex:1; text-align:center; background:#f5f0eb; color:#8d6e63; font-weight:600; padding:12px; border-radius:10px; text-decoration:none; font-size:14px;">
                    ← Cancelar
                </a>
                <button type="submit"
                    style="flex:2; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:10px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Guardar servicio ✂️
                </button>
            </div>
        </form>
    </div>
</div>
@endsection