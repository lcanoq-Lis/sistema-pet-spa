@extends('layouts.app')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #fef3e2 0%, #fde8c8 50%, #e8f5e9 100%);">

    <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <span class="text-2xl">🐾</span>
            <span class="text-xl font-bold" style="color:#5d4037;">Pet Spa</span>
            <span class="text-sm ml-2 px-3 py-1 rounded-full text-white font-semibold"
                style="background:#ff7043;">Admin</span>
        </div>
        <div class="flex items-center gap-4">
            <a href="/dashboard" class="text-sm font-medium hover:underline" style="color:#8d6e63;">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="text-white text-sm font-semibold px-4 py-2 rounded-xl hover:opacity-90"
                    style="background: linear-gradient(135deg, #ef5350, #e53935);">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto mt-10 px-4">

        @if(session('status'))
            <div class="rounded-xl p-4 mb-4 text-sm font-medium" style="background:#e8f5e9; color:#2e7d32;">
                ✅ {{ session('status') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold" style="color:#5d4037;">👥 Personal del Spa</h2>
            <a href="{{ route('admin.personal.create') }}"
                class="text-white font-bold px-5 py-2 rounded-xl hover:opacity-90 transition"
                style="background: linear-gradient(135deg, #ff7043, #ff8f00);">
                + Agregar Personal
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr style="background: linear-gradient(135deg, #ff7043, #ff8f00);">
                        <th class="px-6 py-4 text-white font-semibold">Nombre</th>
                        <th class="px-6 py-4 text-white font-semibold">Email</th>
                        <th class="px-6 py-4 text-white font-semibold">Rol</th>
                        <th class="px-6 py-4 text-white font-semibold">Estado</th>
                        <th class="px-6 py-4 text-white font-semibold">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($personal as $p)
                    <tr class="border-b hover:bg-orange-50 transition">
                        <td class="px-6 py-4 font-medium" style="color:#5d4037;">{{ $p->name }}</td>
                        <td class="px-6 py-4 text-sm" style="color:#8d6e63;">{{ $p->email }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold text-white"
                                style="background: {{ $p->rol->nombre === 'groomer' ? '#7b1fa2' : '#1565c0' }};">
                                {{ ucfirst($p->rol->nombre) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold"
                                style="{{ $p->activo ? 'background:#e8f5e9; color:#2e7d32;' : 'background:#ffebee; color:#c62828;' }}">
                                {{ $p->activo ? '● Activo' : '● Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($p->activo)
                            <form method="POST" action="{{ route('admin.personal.destroy', $p->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('¿Desactivar a {{ $p->name }}? No podrá iniciar sesión.')"
                                    class="text-xs font-semibold px-3 py-1 rounded-lg hover:opacity-90"
                                    style="background:#ffebee; color:#c62828;">
                                    Desactivar
                                </button>
                            </form>
                            @else
                            <span class="text-xs" style="color:#bcaaa4;">Inactivo</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center" style="color:#bcaaa4;">
                            <div class="text-4xl mb-2">🐾</div>
                            No hay personal registrado aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection