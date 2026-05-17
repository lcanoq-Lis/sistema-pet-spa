@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <div class="text-6xl mb-3">🐾</div>
            <h1 class="text-3xl font-bold" style="color: #5d4037;">Pet Spa</h1>
            <p class="text-sm mt-1" style="color: #8d6e63;">Bienvenido de vuelta</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            @if(session('status'))
                <div class="rounded-lg p-3 mb-4 text-sm font-medium" style="background:#e8f5e9; color:#2e7d32;">
                    ✅ {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-lg p-3 mb-4 text-sm font-medium" style="background:#fff3e0; color:#e65100;">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none transition"
                        style="border-color:#d7ccc8; focus:border-color:#ff7043;"
                        placeholder="tu@correo.com" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Contraseña</label>
                    <input type="password" name="password"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none transition"
                        style="border-color:#d7ccc8;"
                        placeholder="••••••••" required>
                </div>

                <button type="submit"
                    class="w-full text-white font-bold py-3 rounded-xl transition hover:opacity-90"
                    style="background: linear-gradient(135deg, #ff7043, #ff8f00);">
                    Iniciar sesión →
                </button>
            </form>

            <div class="my-4 flex items-center gap-3">
                <hr class="flex-1" style="border-color:#efebe9;">
                <span class="text-xs" style="color:#bcaaa4;">o continúa con</span>
                <hr class="flex-1" style="border-color:#efebe9;">
            </div>
            <div style="text-align:right; margin-bottom:16px;">
                <a href="{{ route('password.recuperar') }}" style="font-size:13px; color:#ff7043; text-decoration:none;">
                    ¿Olvidaste tu contraseña?
                </a>
            </div>

            <a href="{{ route('google.redirect') }}"
                class="w-full flex items-center justify-center gap-3 border-2 py-3 rounded-xl transition hover:bg-gray-50 font-medium text-sm"
                style="border-color:#d7ccc8; color:#5d4037;">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                Continuar con Google
            </a>

            <p class="text-center text-sm mt-6" style="color:#8d6e63;">
                ¿No tienes cuenta?
                <a href="{{ route('register') }}" class="font-semibold hover:underline" style="color:#ff7043;">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </div>
</div>
@endsection