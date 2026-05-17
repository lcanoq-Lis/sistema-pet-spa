@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div class="text-6xl mb-3">🐾</div>
            <h1 class="text-3xl font-bold" style="color: #5d4037;">Pet Spa</h1>
            <p class="text-sm mt-1" style="color: #8d6e63;">Crea tu cuenta gratis</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            @if($errors->any())
                <div class="rounded-lg p-3 mb-4 text-sm" style="background:#fff3e0; color:#e65100;">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Nombre completo</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="Tu nombre" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="tu@correo.com" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Teléfono <span class="font-normal" style="color:#bcaaa4;">(opcional)</span></label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="+591 7xxxxxxx">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Contraseña</label>
                    <input type="password" name="password"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="Mín. 8 caracteres" required>
                     <p class="text-xs mt-1" style="color:#bcaaa4;">Debe incluir mayúsculas, minúsculas, números y símbolos.</p>

                        <!-- Medidor de fuerza -->
                        <div class="mt-2">
                            <div class="flex gap-1 mb-1">
                                <div id="bar1" class="h-2 flex-1 rounded-full transition-all duration-300" style="background:#e0e0e0;"></div>
                                <div id="bar2" class="h-2 flex-1 rounded-full transition-all duration-300" style="background:#e0e0e0;"></div>
                                <div id="bar3" class="h-2 flex-1 rounded-full transition-all duration-300" style="background:#e0e0e0;"></div>
                                <div id="bar4" class="h-2 flex-1 rounded-full transition-all duration-300" style="background:#e0e0e0;"></div>
                            </div>
                            <p id="strength-text" class="text-xs font-semibold" style="color:#bcaaa4;">Escribe tu contraseña</p>
                        </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold mb-1" style="color:#5d4037;">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border-2 rounded-xl px-4 py-3 text-sm focus:outline-none"
                        style="border-color:#d7ccc8;" placeholder="Repite tu contraseña" required>
                </div>

                <button type="submit"
                    class="w-full text-white font-bold py-3 rounded-xl transition hover:opacity-90"
                    style="background: linear-gradient(135deg, #43a047, #66bb6a);">
                    Crear cuenta 🐾
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color:#8d6e63;">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="font-semibold hover:underline" style="color:#ff7043;">
                    Inicia sesión
                </a>
            </p>
        </div>
    </div>
</div>
<script>
document.querySelector('input[name="password"]').addEventListener('input', function() {
    const password = this.value;
    const bars = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4')
    ];
    const text = document.getElementById('strength-text');

    let score = 0;
    if (password.length >= 8) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/[0-9]/.test(password)) score++;
    if (/[@$!%*#?&]/.test(password)) score++;

    const colors = ['#ef5350', '#ff7043', '#ffa726', '#43a047'];
    const labels = ['Muy débil', 'Débil', 'Aceptable', 'Fuerte 💪'];
    const textColors = ['#ef5350', '#ff7043', '#ffa726', '#43a047'];

    bars.forEach((bar, i) => {
        bar.style.background = i < score ? colors[score - 1] : '#e0e0e0';
    });

    if (password.length === 0) {
        text.textContent = 'Escribe tu contraseña';
        text.style.color = '#bcaaa4';
    } else {
        text.textContent = labels[score - 1] || 'Muy débil';
        text.style.color = textColors[score - 1] || '#ef5350';
    }
});
</script>
@endsection