<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificación Pet Spa</title>
</head>
<body style="font-family:Arial,sans-serif; background:#f4f4f4; padding:30px;">
    <div style="background:white; max-width:500px; margin:auto; padding:30px; border-radius:10px;">

        @if($tipo === 'confirmada')
            <h2 style="color:#ff7043;">✅ ¡Cita Confirmada!</h2>
            <p>Hola <strong>{{ $cliente->nombre }}</strong>,</p>
            <p>Tu cita ha sido confirmada con los siguientes detalles:</p>

        @elseif($tipo === 'listo_recoger')
            <h2 style="color:#43a047;">🐾 ¡Tu mascota está lista!</h2>
            <p>Hola <strong>{{ $cliente->nombre }}</strong>,</p>
            <p><strong>{{ $cita->mascota->nombre }}</strong> ya terminó su servicio y está listo para ser recogido.</p>

        @elseif($tipo === 'recordatorio')
            <h2 style="color:#1565c0;">📅 Recordatorio de cita</h2>
            <p>Hola <strong>{{ $cliente->nombre }}</strong>,</p>
            <p>Te recordamos que tienes una cita mañana:</p>
        @endif

        <div style="background:#f5f0eb; border-radius:10px; padding:16px; margin:20px 0;">
            <p><strong>🐾 Mascota:</strong> {{ $cita->mascota->nombre }}</p>
            <p><strong>✂️ Servicio:</strong> {{ $cita->servicio->nombre }}</p>
            <p><strong>📅 Fecha:</strong> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
            <p><strong>🕐 Hora:</strong> {{ $cita->fecha_hora_inicio->format('H:i') }}</p>
            <p><strong>💰 Precio:</strong> Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
        </div>

        <p style="color:#888; font-size:12px;">Pet Spa — Cuidamos a tu mascota con amor 🐾</p>
    </div>
</body>
</html>