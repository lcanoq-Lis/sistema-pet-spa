@extends('layouts.dashboard')

@section('page-title', '🔍 Panel de Auditoría')
@section('page-subtitle', 'Registro de todas las acciones del sistema')

@section('content')

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:linear-gradient(135deg,#ff7043,#ff8f00);">
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Usuario / Rol</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Acción</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Descripción</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">IP / Navegador</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Fecha y Hora</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
            <tr style="border-bottom:1px solid #f5f0eb; {{ $loop->even ? 'background:#fafafa;' : '' }}">
                <td style="padding:12px 16px;">
                    <p style="font-weight:700; color:#5d4037; font-size:13px;">
                        {{ $log->usuario?->name ?? 'Sin usuario' }}
                    </p>
                    <p style="font-size:11px; color:#a1887f;">ID: {{ $log->usuario_id ?? '--' }}</p>
                    <span style="background:#fff3e0; color:#e65100; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:600;">
                        {{ ucfirst($log->rol ?? 'sin rol') }}
                    </span>
                </td>
                <td style="padding:12px 16px;">
                    <span style="background:#e8f5e9; color:#2e7d32; padding:4px 10px; border-radius:10px; font-size:12px; font-weight:600;">
                        {{ $log->evento }}
                    </span>
                </td>
                <td style="padding:12px 16px; font-size:13px; color:#5d4037; max-width:250px;">
                    {{ $log->descripcion ?? '—' }}
                </td>
                <td style="padding:12px 16px;">
                    <p style="font-size:12px; color:#5d4037; font-weight:600;">{{ $log->ip_address ?? '—' }}</p>
                    <p style="font-size:11px; color:#a1887f; max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ $log->user_agent ? substr($log->user_agent, 0, 50) . '...' : '—' }}
                    </p>
                </td>
                <td style="padding:12px 16px;">
                    <p style="font-size:13px; color:#5d4037; font-weight:600;">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y') }}
                    </p>
                    <p style="font-size:12px; color:#a1887f;">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}
                    </p>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="padding:48px; text-align:center; color:#a1887f;">
                    No hay registros de auditoría.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Paginación --}}
<div style="margin-top:16px;">
    {{ $logs->links() }}
</div>

@endsection