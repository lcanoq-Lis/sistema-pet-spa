@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="text-6xl mb-3">🔐</div>
            <h1 class="text-3xl font-bold" style="color: #5d4037;">Verificación 2FA</h1>
            <p class="text-sm mt-1" style="color: #8d6e63;">Ingresa el código de Google Authenticator</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            @if($errors->any())
                <div class="rounded-xl p-3 mb-4 text-sm" style="background:#ffebee; color:#c62828;">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('2fa.verify.post') }}">
                @csrf
                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">
                        Código de 6 dígitos
                    </label>
                    <input type="text" name="code" maxlength="6"
                        class="w-full border-2 rounded-xl px-4 py-3 text-center text-2xl tracking-widest focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="000000" required autofocus>
                </div>
                <button type="submit"
                    class="w-full text-white font-bold py-3 rounded-xl transition hover:opacity-90"
                    style="background: linear-gradient(135deg, #ff7043, #ff8f00);">
                    Verificar →
                </button>
            </form>
        </div>
    </div>
</div>
@endsection