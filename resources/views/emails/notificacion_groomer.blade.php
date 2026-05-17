<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva cita asignada</title>
</head>
<body style="font-family:Arial,sans-serif; background:#f4f4f4; padding:30px;">
    <div style="background:white; max-width:500px; margin:auto; padding:30px; border-radius:10px;">
        <h2 style="color:#ff7043;">📅 Nueva cita asignada</h2>
        <p>Hola <strong>{{ $groomer->nombre }}</strong>,</p>
        <p>Se te ha asignado una nueva cita con los siguientes detalles:</p>

        <div style="background:#f5f0eb; border-radius:10px; padding:16px; margin:20px 0;">
            <p><strong>🐾 Mascota:</strong> {{ $cita->mascota->nombre }}</p>
            <p><strong>🐕 Especie:</strong> {{ ucfirst($cita->mascota->especie) }}</p>
            <p><strong>✂️ Servicio:</strong> {{ $cita->servicio->nombre }}</p>
            <p><strong>📅 Fecha:</strong> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
            <p><strong>🕐 Hora:</strong> {{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}</p>
            @if($cita->mascota->alergias)
            <p style="color:#e65100;"><strong>⚠️ Alergias:</strong> {{ $cita->mascota->alergias }}</p>
            @endif
            @if($cita->mascota->restricciones_medicas)
            <p style="color:#e65100;"><strong>⚠️ Restricciones:</strong> {{ $cita->mascota->restricciones_medicas }}</p>
            @endif
            @if($cita->notas_cliente)
            <p><strong>📝 Notas del cliente:</strong> {{ $cita->notas_cliente }}</p>
            @endif
        </div>

        <p style="color:#888; font-size:12px;">Pet Spa — Por favor confirma o cancela la cita desde tu panel.</p>
    </div>
</body>
</html>