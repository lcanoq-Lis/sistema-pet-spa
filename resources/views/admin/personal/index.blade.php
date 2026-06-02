@extends('layouts.dashboard')

@section('page-title', 'Personal del Spa')
@section('page-subtitle', 'Gestión de groomers y recepción')

@section('content')

@if(session('status'))
    <div style="background:#E8F5E9; border-left:4px solid #2E7D32; border-radius:12px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:10px;">
        <i class="ti ti-circle-check" style="color:#2E7D32; font-size:18px;"></i>
        <p style="color:#2E7D32; font-size:13px; font-weight:600; margin:0;">{{ session('status') }}</p>
    </div>
@endif

<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:16px;">
    <div style="display:flex; align-items:center; gap:10px;">
        <div style="width:36px; height:36px; background:linear-gradient(135deg, #FF7043, #F57F17); border-radius:10px; display:flex; align-items:center; justify-content:center;">
            <i class="ti ti-users" style="font-size:18px; color:#fff;"></i>
        </div>
        <h2 style="font-size:18px; font-weight:700; color:#1A2E1A; margin:0;">Personal del Spa</h2>
    </div>
    <a href="{{ route('admin.personal.create') }}"
        style="background:linear-gradient(135deg, #FF7043, #F57F17); color:#fff; font-weight:600; padding:10px 24px; border-radius:40px; text-decoration:none; font-size:13px; display:inline-flex; align-items:center; gap:8px;">
        <i class="ti ti-user-plus" style="font-size:14px;"></i> Agregar Personal
    </a>
</div>

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow-x:auto; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="min-width:800px; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:linear-gradient(135deg, #1B5E20, #0D3B0D);">
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Nombre</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Email</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Rol</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Estado</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personal as $p)
                <tr style="border-bottom:1px solid #F0F0EA; {{ $loop->even ? 'background:#FAFBF8;' : '' }}">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; background:linear-gradient(135deg, #FF7043, #F57F17); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-user" style="font-size:20px; color:#fff;"></i>
                            </div>
                            <span style="font-weight:700; color:#1A2E1A; font-size:14px;">{{ $p->name }}</span>
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:13px; color:#1A2E1A; margin:0; display:flex; align-items:center; gap:6px;">
                            <i class="ti ti-mail" style="font-size:12px; color:#8A9B8A;"></i> {{ $p->email }}
                        </p>
                    </td>
                    <td style="padding:16px 20px;">
                        @if($p->rol->nombre === 'groomer')
                            <span style="background:#F3E5F5; color:#6A1B9A; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-scissors" style="font-size:11px;"></i> Groomer
                            </span>
                        @else
                            <span style="background:#E3F2FD; color:#1565C0; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-clipboard" style="font-size:11px;"></i> Recepción
                            </span>
                        @endif
                    </td>
                    <td style="padding:16px 20px;">
                        @if($p->activo)
                            <span style="background:#E8F5E9; color:#2E7D32; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-circle-filled" style="font-size:8px;"></i> Activo
                            </span>
                        @else
                            <span style="background:#FFEBEE; color:#C62828; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-circle-x" style="font-size:8px;"></i> Inactivo
                            </span>
                        @endif
                    </td>
                    <td style="padding:16px 20px;">
                        @if($p->activo)
                        <form method="POST" action="{{ route('admin.personal.destroy', $p->id) }}" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Desactivar a {{ $p->name }}? No podrá iniciar sesión.')"
                                style="background:#FFEBEE; color:#C62828; border:none; border-radius:30px; padding:8px 18px; font-size:11px; font-weight:700; cursor:pointer; display:inline-flex; align-items:center; gap:6px; transition:all 0.2s;">
                                <i class="ti ti-user-off" style="font-size:12px;"></i> Desactivar
                            </button>
                        </form>
                        @else
                            <span style="background:#F5F5F0; color:#8A9B8A; padding:8px 18px; border-radius:30px; font-size:11px; font-weight:600; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-lock" style="font-size:11px;"></i> Inactivo
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:56px 24px; text-align:center;">
                        <div style="width:72px; height:72px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="ti ti-users" style="font-size:32px; color:#8A9B8A;"></i>
                        </div>
                        <h3 style="font-size:16px; font-weight:700; color:#1A2E1A; margin:0;">No hay personal registrado</h3>
                        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Agrega tu primer empleado al sistema</p>
                        <a href="{{ route('admin.personal.create') }}" style="display:inline-flex; align-items:center; gap:6px; margin-top:12px; color:#FF7043; font-size:13px; font-weight:600; text-decoration:none;">
                            <i class="ti ti-user-plus"></i> Agregar personal
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection