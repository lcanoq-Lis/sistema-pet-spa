@extends('layouts.dashboard')

@section('page-title', '🔔 Notificaciones')
@section('page-subtitle', 'Historial de notificaciones enviadas')

@section('content')

<div class="stat-card" style="padding:0; overflow:hidden;">
    <table style="width:100%; border-collapse:collapse;">
        <thead>
            <tr style="background:linear-gradient(135deg,#ff7043,#ff8f00);">
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Cliente</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Mascota</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Tipo</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Canal</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Estado</th>
                <th style="padding:14px 16px; color:white; font-size:13px; text-align:left;">Fecha envío</th>
            </tr>
        </thead>
        <tbody>
            @forelse($notificaciones as $noti)
            <tr style="border-bottom:1px solid #f5f0eb; {{ $loop->even ? 'background:#fafafa;' : '' }}">
                <td style="padding:12px 16px;">
                    <p style="font-weight:700; color:#5d4037; font-size:13px;">{{ $noti->cliente?->nombre ?? '—' }}</p>
                    <p style="font-size:11px; color:#a1887f;">{{ $noti->destino }}</p>
                </td>
                <td style="padding:12px 16px; font-size:13px; color:#5d4037;">
                    {{ $noti->cita?->mascota?->nombre ?? '—' }}
                </td>
                <td style="padding:12px 16px;">
                    @php
                        $tipos = [
                            'confirmacion'    => ['bg'=>'#e8f5e9', 'color'=>'#2e7d32', 'label'=>'✅ Confirmación'],
                            'listo_recoger'   => ['bg'=>'#f3e5f5', 'color'=>'#6a1b9a', 'label'=>'🐾 Lista para recoger'],
                            'recordatorio_24h'=> ['bg'=>'#e3f2fd', 'color'=>'#1565c0', 'label'=>'📅 Recordatorio 24h'],
                            'recordatorio_2h' => ['bg'=>'#fff3e0', 'color'=>'#e65100', 'label'=>'⏰ Recordatorio 2h'],
                        ];
                        $t = $tipos[$noti->tipo_evento] ?? ['bg'=>'#f5f5f5', 'color'=>'#333', 'label'=>$noti->tipo_evento];
                    @endphp
                    <span style="background:{{ $t['bg'] }}; color:{{ $t['color'] }}; padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                        {{ $t['label'] }}
                    </span>
                </td>
                <td style="padding:12px 16px; font-size:13px; color:#5d4037;">
                    {{ ucfirst($noti->canal) }}
                </td>
                <td style="padding:12px 16px;">
                    <span style="background:{{ $noti->estado === 'enviado' ? '#e8f5e9' : ($noti->estado === 'fallido' ? '#ffebee' : '#fff3e0') }};
                                 color:{{ $noti->estado === 'enviado' ? '#2e7d32' : ($noti->estado === 'fallido' ? '#c62828' : '#e65100') }};
                                 padding:4px 10px; border-radius:20px; font-size:11px; font-weight:600;">
                        {{ ucfirst($noti->estado) }}
                    </span>
                </td>
                <td style="padding:12px 16px; font-size:13px; color:#5d4037;">
                    {{ $noti->fecha_envio ? \Carbon\Carbon::parse($noti->fecha_envio)->format('d/m/Y H:i') : '—' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:48px; text-align:center; color:#a1887f;">
                    <div style="font-size:48px; margin-bottom:12px;">🔔</div>
                    No hay notificaciones registradas.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div style="margin-top:16px;">
    {{ $notificaciones->links() }}
</div>

@endsection