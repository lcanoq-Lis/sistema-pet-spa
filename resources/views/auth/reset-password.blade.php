@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-md">

        <div class="text-center mb-8">
            <div style="font-size:64px;">🔑</div>
            <h1 style="font-size:28px; font-weight:800; color:#5d4037;">Nueva contraseña</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">

            @if($errors->any())
                <div style="background:#fff3e0; color:#e65100; border-left:4px solid #ff7043; padding:12px 16px; border-radius:8px; margin-bottom:16px; font-size:14px;">
                    <ul style="margin:0; padding-left:16px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.reset.post') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div style="margin-bottom:16px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Nueva contraseña *</label>
                    <input type="password" name="password"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:12px; padding:12px 16px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                    <p style="font-size:12px; color:#a1887f; margin-top:4px;">Mínimo 8 caracteres con mayúsculas, minúsculas, números y símbolos.</p>
                </div>

                <div style="margin-bottom:24px;">
                    <label style="display:block; font-size:13px; font-weight:600; color:#5d4037; margin-bottom:6px;">Confirmar contraseña *</label>
                    <input type="password" name="password_confirmation"
                        style="width:100%; border:2px solid #d7ccc8; border-radius:12px; padding:12px 16px; font-size:14px; outline:none; font-family:Poppins,sans-serif;"
                        required>
                </div>

                <button type="submit"
                    style="width:100%; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; font-weight:700; padding:12px; border-radius:12px; border:none; cursor:pointer; font-size:14px; font-family:Poppins,sans-serif;">
                    Restablecer contraseña 🔐
                </button>
            </form>
        </div>
    </div>
</div>
@endsection