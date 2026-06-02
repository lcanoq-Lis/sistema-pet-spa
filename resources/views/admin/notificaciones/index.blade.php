@extends('layouts.dashboard')

@section('page-title', 'Notificaciones')
@section('page-subtitle', 'Historial de notificaciones enviadas')

@section('content')

<div style="background:#fff; border-radius:20px; border:0.5px solid #e0e0e0; overflow-x:auto; box-shadow:0 2px 8px rgba(0,0,0,0.02);">
    <div style="min-width:1000px; overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:linear-gradient(135deg, #2E7D32, #1B5E20);">
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;"><i class="ti ti-user" style="font-size:14px;"></i> Cliente</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;"><i class="ti ti-dog" style="font-size:14px;"></i> Mascota</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;"><i class="ti ti-bell" style="font-size:14px;"></i> Tipo</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;"><i class="ti ti-device-mobile" style="font-size:14px;"></i> Canal</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;"><i class="ti ti-status-change" style="font-size:14px;"></i> Estado</th>
                    <th style="padding:16px 20px; color:#fff; font-size:12px; font-weight:600; text-align:left;"><i class="ti ti-calendar" style="font-size:14px;"></i> Fecha envío</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notificaciones as $noti)
                <tr style="border-bottom:1px solid #F0F0EA; {{ $loop->even ? 'background:#FAFBF8;' : '' }}">
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:12px;">
                            <div style="width:40px; height:40px; background:linear-gradient(135deg, #2E7D32, #43A047); border-radius:12px; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-user" style="font-size:20px; color:#fff;"></i>
                            </div>
                            <div>
                                <p style="font-weight:700; color:#1A2E1A; font-size:14px; margin:0;">{{ $noti->cliente?->name ?? $noti->cliente?->nombre ?? '—' }}</p>
                                <p style="font-size:11px; color:#8A9B8A; margin:2px 0 0; display:flex; align-items:center; gap:4px;">
                                    <i class="ti ti-mail" style="font-size:10px;"></i> {{ $noti->destino }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <div style="width:32px; height:32px; background:#E8F5E9; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-dog" style="font-size:16px; color:#2E7D32;"></i>
                            </div>
                            <span style="font-size:13px; font-weight:600; color:#1A2E1A;">{{ $noti->cita?->mascota?->nombre ?? '—' }}</span>
                        </div>
                    </td>
                    <td style="padding:16px 20px;">
                        @php
                            $tipos = [
                                'confirmacion'    => ['bg'=>'#E8F5E9', 'color'=>'#2E7D32', 'icon'=>'ti-check', 'label'=>'Confirmación'],
                                'listo_recoger'   => ['bg'=>'#E8F5E9', 'color'=>'#2E7D32', 'icon'=>'ti-paw', 'label'=>'Listo para recoger'],
                                'recordatorio_24h'=> ['bg'=>'#E8F5E9', 'color'=>'#2E7D32', 'icon'=>'ti-calendar', 'label'=>'Recordatorio 24h'],
                                'recordatorio_2h' => ['bg'=>'#E8F5E9', 'color'=>'#F57F17', 'icon'=>'ti-clock', 'label'=>'Recordatorio 2h'],
                            ];
                            $t = $tipos[$noti->tipo_evento] ?? ['bg'=>'#F5F5F0', 'color'=>'#8A9B8A', 'icon'=>'ti-bell', 'label'=>$noti->tipo_evento];
                        @endphp
                        <span style="background:{{ $t['bg'] }}; color:{{ $t['color'] }}; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                            <i class="ti {{ $t['icon'] }}" style="font-size:11px;"></i> {{ $t['label'] }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;">
                        <span style="display:inline-flex; align-items:center; gap:6px; background:#F5F5F0; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:600; color:#5D6E5D;">
                            @if($noti->canal === 'whatsapp')
                                <i class="ti ti-brand-whatsapp" style="font-size:12px; color:#25D366;"></i>
                            @elseif($noti->canal === 'email')
                                <i class="ti ti-mail" style="font-size:12px; color:#2E7D32;"></i>
                            @elseif($noti->canal === 'sms')
                                <i class="ti ti-message" style="font-size:12px; color:#F57F17;"></i>
                            @else
                                <i class="ti ti-bell" style="font-size:12px;"></i>
                            @endif
                            {{ ucfirst($noti->canal) }}
                        </span>
                    </td>
                    <td style="padding:16px 20px;">
                        @if($noti->estado === 'enviado')
                            <span style="background:#E8F5E9; color:#2E7D32; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-circle-check" style="font-size:11px;"></i> Enviado
                            </span>
                        @elseif($noti->estado === 'fallido')
                            <span style="background:#FFEBEE; color:#C62828; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-alert-circle" style="font-size:11px;"></i> Fallido
                            </span>
                        @else
                            <span style="background:#FFF8E1; color:#F57F17; padding:5px 14px; border-radius:30px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:4px;">
                                <i class="ti ti-clock" style="font-size:11px;"></i> Pendiente
                            </span>
                        @endif
                    </td>
                    <td style="padding:16px 20px; white-space:nowrap;">
                        <div style="display:flex; align-items:center; gap:6px;">
                            <div style="width:32px; height:32px; background:#E8F5E9; border-radius:10px; display:flex; align-items:center; justify-content:center;">
                                <i class="ti ti-calendar" style="font-size:14px; color:#2E7D32;"></i>
                            </div>
                            <div>
                                <p style="font-size:13px; font-weight:600; color:#1A2E1A; margin:0;">
                                    {{ $noti->fecha_envio ? \Carbon\Carbon::parse($noti->fecha_envio)->format('d/m/Y') : '—' }}
                                </p>
                                <p style="font-size:10px; color:#8A9B8A; margin:2px 0 0;">
                                    {{ $noti->fecha_envio ? \Carbon\Carbon::parse($noti->fecha_envio)->format('H:i:s') : '—' }}
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding:56px 24px; text-align:center;">
                        <div style="width:72px; height:72px; background:#E8F5E9; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                            <i class="ti ti-bell-off" style="font-size:32px; color:#2E7D32;"></i>
                        </div>
                        <h3 style="font-size:16px; font-weight:700; color:#1A2E1A; margin:0;">No hay notificaciones</h3>
                        <p style="color:#8A9B8A; margin-top:6px; font-size:13px;">Las notificaciones aparecerán aquí cuando se envíen</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Paginación --}}
@if(method_exists($notificaciones, 'links'))
<div style="margin-top:24px; display:flex; justify-content:center;">
    {{ $notificaciones->links() }}
</div>
@endif

@endsection