@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="text-6xl mb-3">🔐</div>
            <h1 class="text-3xl font-bold" style="color: #5d4037;">Configurar 2FA</h1>
            <p class="text-sm mt-1" style="color: #8d6e63;">Configura Google Authenticator</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="rounded-xl p-4 mb-6" style="background:#fff3e0;">
                <p class="text-sm font-semibold mb-3" style="color:#e65100;">Sigue estos pasos:</p>
                <ol class="text-sm space-y-2" style="color:#5d4037;">
                    <li>1. Abre <strong>Google Authenticator</strong> en tu celular</li>
                    <li>2. Toca <strong>"Agregar cuenta"</strong></li>
                    <li>3. Elige <strong>"Ingresar clave de configuración"</strong></li>
                    <li>4. Ingresa estos datos:</li>
                </ol>
                <div class="rounded-xl p-4 mt-3" style="background:white; border: 2px solid #ffe0b2;">
                    <p class="text-xs" style="color:#bcaaa4;">Cuenta:</p>
                    <p class="font-bold" style="color:#5d4037;">Pet Spa - {{ Auth::user()->email }}</p>
                    <p class="text-xs mt-2" style="color:#bcaaa4;">Clave secreta:</p>
                    <p class="font-mono font-bold text-lg tracking-widest" style="color:#ff7043;">{{ $secret }}</p>
                </div>
            </div>

            @if($errors->any())
                <div class="rounded-xl p-3 mb-4 text-sm" style="background:#ffebee; color:#c62828;">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('2fa.activate') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">
                        Código de 6 dígitos de la app
                    </label>
                    <input type="text" name="code" maxlength="6"
                        class="w-full border-2 rounded-xl px-4 py-3 text-center text-2xl tracking-widest focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="000000" required>
                </div>
                <button type="submit"
                    class="w-full text-white font-bold py-3 rounded-xl transition hover:opacity-90"
                    style="background: linear-gradient(135deg, #ff7043, #ff8f00);">
                    Activar 2FA ✓
                </button>
            </form>
        </div>
    </div>
</div>
@endsection