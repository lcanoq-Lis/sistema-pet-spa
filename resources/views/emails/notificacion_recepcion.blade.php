<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva cita por confirmar</title>
</head>
<body style="font-family:Arial,sans-serif; background:#f4f4f4; padding:30px;">
    <div style="background:white; max-width:500px; margin:auto; padding:30px; border-radius:10px;">
        <h2 style="color:#1565c0;">📅 Nueva cita por confirmar</h2>
        <p>Hola <strong>{{ $recepcionista->name }}</strong>,</p>
        <p>Se ha registrado una nueva cita que requiere confirmación:</p>

        <div style="background:#f5f0eb; border-radius:10px; padding:16px; margin:20px 0;">
            <p><strong>🐾 Mascota:</strong> {{ $cita->mascota->nombre }}</p>
            <p><strong>✂️ Servicio:</strong> {{ $cita->servicio->nombre }}</p>
            <p><strong>📅 Fecha:</strong> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
            <p><strong>🕐 Hora:</strong> {{ $cita->fecha_hora_inicio->format('H:i') }}</p>
            <p><strong>👤 Groomer:</strong> {{ $cita->groomer?->nombre ?? 'Sin asignar' }}</p>
            <p><strong>💰 Precio:</strong> Bs. {{ number_format($cita->precio_acordado, 2) }}</p>
        </div>

        <p>Por favor ingresa al sistema para confirmar o cancelar la cita.</p>
        <p style="color:#888; font-size:12px;">Pet Spa — Sistema de gestión 🐾</p>
    </div>
</body>
</html>