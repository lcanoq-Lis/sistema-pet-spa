<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago Recibido — Pet Spa</title>
</head>
<body style="margin:0; padding:0; background:#F0F5F0; font-family:'Segoe UI', Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#F0F5F0; padding:40px 0;">
    <tr>
        <td align="center">
            <table width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%;">

                {{-- Header --}}
                <tr>
                    <td style="background:linear-gradient(135deg, #2E7D32, #1B5E20); border-radius:16px 16px 0 0; padding:36px 40px; text-align:center;">
                        <div style="font-size:48px; margin-bottom:12px;">🐾</div>
                        <h1 style="color:#fff; font-size:24px; font-weight:800; margin:0;">Pet Spa</h1>
                        <p style="color:#A5D6A7; font-size:14px; margin:6px 0 0;">Confirmación de pago</p>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="background:#fff; padding:40px;">

                        {{-- Saludo --}}
                        <p style="font-size:16px; color:#1A2E1A; font-weight:600; margin:0 0 8px;">
                            Hola, {{ $pago->cita->creadoPor->name ?? 'Cliente' }} 👋
                        </p>
                        <p style="font-size:14px; color:#4F6B4F; margin:0 0 28px; line-height:1.6;">
                            Tu pago ha sido registrado exitosamente. Aquí tienes el resumen de tu cita.
                        </p>

                        {{-- Badge confirmado --}}
                        <div style="background:#E8F5E9; border-radius:12px; padding:16px 20px; text-align:center; margin-bottom:28px;">
                            <span style="color:#2E7D32; font-weight:800; font-size:18px;">✅ Pago Confirmado</span>
                        </div>

                        {{-- Detalle cita --}}
                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#8A9B8A; font-size:13px; width:40%;">Mascota</td>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#1A2E1A; font-size:13px; font-weight:600;">
                                    {{ $pago->cita->mascota->nombre ?? '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#8A9B8A; font-size:13px;">Servicio</td>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#1A2E1A; font-size:13px; font-weight:600;">
                                    {{ $pago->cita->servicio->nombre ?? '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#8A9B8A; font-size:13px;">Fecha</td>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#1A2E1A; font-size:13px; font-weight:600;">
                                    {{ $pago->cita->fecha_hora_inicio?->format('d/m/Y H:i') ?? '—' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#8A9B8A; font-size:13px;">Método de pago</td>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#1A2E1A; font-size:13px; font-weight:600;">
                                    {{ ucfirst($pago->metodo) }}
                                </td>
                            </tr>
                            @if($pago->descuento > 0)
                            <tr>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#8A9B8A; font-size:13px;">Descuento</td>
                                <td style="padding:10px 0; border-bottom:1px solid #F0F5F0; color:#2E7D32; font-size:13px; font-weight:600;">
                                    -Bs. {{ number_format($pago->descuento, 2) }}
                                </td>
                            </tr>
                            @endif
                        </table>

                        {{-- Total --}}
                        <div style="background:#F0F5F0; border-radius:12px; padding:20px 24px; display:flex; justify-content:space-between; align-items:center; margin-bottom:28px;">
                            <span style="color:#4F6B4F; font-size:15px; font-weight:600;">Total pagado</span>
                            <span style="color:#2E7D32; font-size:26px; font-weight:800;">Bs. {{ number_format($pago->total, 2) }}</span>
                        </div>

                        @if($pago->referencia)
                        <p style="font-size:12px; color:#8A9B8A; margin:0 0 28px;">
                            <strong>Referencia:</strong> {{ $pago->referencia }}
                        </p>
                        @endif

                        <p style="font-size:13px; color:#4F6B4F; line-height:1.6; margin:0;">
                            Gracias por confiar en <strong>Pet Spa</strong>. Si tienes alguna duda, contáctanos por WhatsApp al
                            <a href="https://wa.me/59174260228" style="color:#2E7D32; font-weight:600;">+591 74260228</a>.
                        </p>
                    </td>
                </tr>

                {{-- Footer --}}
                <tr>
                    <td style="background:#F0F5F0; border-radius:0 0 16px 16px; padding:20px 40px; text-align:center;">
                        <p style="color:#8A9B8A; font-size:12px; margin:0;">
                            🐾 Pet Spa — Cuidamos a tu mascota con amor
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
