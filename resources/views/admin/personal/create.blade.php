@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="text-6xl mb-3">👤</div>
            <h1 class="text-3xl font-bold" style="color: #5d4037;">Agregar Personal</h1>
            <p class="text-sm mt-1" style="color: #8d6e63;">Se enviará un email con las credenciales</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            @if($errors->any())
                <div class="rounded-xl p-3 mb-4 text-sm" style="background:#fff3e0; color:#e65100;">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.personal.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="Nombre del empleado" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="correo@ejemplo.com" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Rol</label>
                    <select name="rol"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" required>
                        <option value="">Selecciona un rol</option>
                        <option value="groomer" {{ old('rol') === 'groomer' ? 'selected' : '' }}>🐩 Groomer</option>
                        <option value="recepcion" {{ old('rol') === 'recepcion' ? 'selected' : '' }}>📋 Recepción</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Teléfono <span class="font-normal" style="color:#bcaaa4;">(opcional)</span></label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="+591 7xxxxxxx">
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Especialidad <span class="font-normal" style="color:#bcaaa4;">(solo Groomers)</span></label>
                    <input type="text" name="especialidad" value="{{ old('especialidad') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="Ej: Corte fino, razas pequeñas...">
                </div>

                <button type="submit"
                    class="w-full text-white font-bold py-3 rounded-xl transition hover:opacity-90"
                    style="background: linear-gradient(135deg, #ff7043, #ff8f00);">
                    Crear cuenta y enviar credenciales 📧
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('admin.personal.index') }}" class="text-sm font-semibold hover:underline" style="color:#ff7043;">
                    ← Volver al listado
                </a>
            </div>
        </div>
    </div>
</div>
@endsection