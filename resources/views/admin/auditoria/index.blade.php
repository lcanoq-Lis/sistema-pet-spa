@extends('layouts.dashboard')

@section('page-title', 'Panel de Auditoría')
@section('page-subtitle', 'Registro de todas las acciones del sistema')

@section('content')

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow-x:auto; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="min-width:900px; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:linear-gradient(135deg, #1B5E20, #0D3B0D);">
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Usuario / Rol</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Acción</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Descripción</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">IP / Navegador</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;">Fecha y Hora</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr style="border-bottom:1px solid #F0F0EA; {{ $loop->even ? 'background:#FAFBF8;' : '' }}">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; background:linear-gradient(135deg, #FF7043, #F57F17); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-user" style="font-size:20px; color:#fff;"></i>
                            </div>
                            <div>
                                <p style="font-weight:700; color:#1A2E1A; font-size:14px; margin:0;">
                                    {{ $log->usuario?->name ?? 'Sin usuario' }}
                                </p>
                                <p style="font-size:11px; color:#8A9B8A; margin:2px 0 0; display:flex; align-items:center; gap:4px;">
                                    <i class="ti ti-id-badge" style="font-size:10px;"></i> ID: {{ $log->usuario_id ?? '--' }}
                                </p>
                                <span style="background:#FFF8E1; color:#F57F17; padding:3px 10px; border-radius:20px; font-size:10px; font-weight:700; display:inline-flex; align-items:center; gap:4px; margin-top:4px;">
                                    <i class="ti ti-shield" style="font-size:10px;"></i> {{ ucfirst($log->rol ?? 'sin rol') }}
                                </span>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        <span style="background:#E8F5E9; color:#2E7D32; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                            <i class="ti ti-activity" style="font-size:11px;"></i> {{ $log->evento }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:13px; color:#1A2E1A; margin:0; max-width:280px; word-break:break-word;">
                            {{ $log->descripcion ?? '—' }}
                        </p>
                    </td>
                    <td style="padding:16px 20px;">
                        <p style="font-size:12px; color:#1A2E1A; font-weight:600; margin:0; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-device-computer" style="font-size:12px; color:#8A9B8A;"></i> {{ $log->ip_address ?? '—' }}
                        </p>
                        <p style="font-size:10px; color:#8A9B8A; margin:4px 0 0; max-width:180px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-globe" style="font-size:10px;"></i> {{ $log->user_agent ? substr($log->user_agent, 0, 45) . '...' : '—' }}
                        </p>
                    </td>
                    <td style="padding:16px 20px; white-space:nowrap;">
                        <p style="font-size:13px; color:#1A2E1A; font-weight:700; margin:0; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-calendar" style="font-size:12px; color:#8A9B8A;"></i> {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y') }}
                        </p>
                        <p style="font-size:11px; color:#8A9B8A; margin:4px 0 0; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-clock" style="font-size:10px;"></i> {{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}
                        </p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:56px 24px; text-align:center;">
                        <div style="width:64px; height:64px; background:#F5F5F0; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="ti ti-shield-search" style="font-size:28px; color:#8A9B8A;"></i>
                        </div>
                        <p style="color:#8A9B8A; font-size:14px; margin:0;">No hay registros de auditoría.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if(method_exists($logs, 'links'))
<div style="margin-top:24px; display:flex; justify-content:center;">
    {{ $logs->links() }}
</div>
@endif

@endsection