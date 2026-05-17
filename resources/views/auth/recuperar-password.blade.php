@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div style="font-size:64px;">🔐</div>
            <h1 style="font-size:28px; font-weight:800; color:#5d4037;">Recuperar contraseña</h1>
            <p style="font-size:14px; color:#a1887f; margin-top:4px;">Te enviaremos un link a tu correo</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            @if(session('status'))
                <div style="background:#e8f5e9; color:#2e7d32; border-left:4px solid #43a047; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
                    ✅ {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.recuperar.post') }}">
                @csrf
                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:12px; padding:12px 16px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        placeholder="tu@correo.com" required>
                </div>

                <button type="submit"
                    style="width:100%; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:12px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Enviar link de recuperación 📧
                </button>
            </form>

            <p style="text-align:center; font-size:13px; color:#a1887f; margin-top:16px;">
                <a href="{{ route('login') }}" style="color:#ff7043; font-weight:600; text-decoration:none;">← Volver al login</a>
            </p>
        </div>
    </div>
</div>
@endsection