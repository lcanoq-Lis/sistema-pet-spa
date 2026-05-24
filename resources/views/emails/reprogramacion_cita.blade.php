<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif; background:#f5f5f5; padding:20px;">
<div style="max-width:500px; margin:0 auto; background:white; border-radius:12px; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#ff7043,#ff8f00); padding:24px; text-align:center;">
        <div style="font-size:40px;">📅</div>
        <h2 style="color:white; margin:8px 0 0;">Cita Reprogramada</h2>
        <p style="color:rgba(255,255,255,0.85); font-size:13px; margin:4px 0 0;">Pet Spa</p>
    </div>
    <div style="padding:24px;">
        <p style="font-size:14px; color:#5d4037;">Hola <strong>{{ $usuario->name }}</strong>,</p>
        <p style="font-size:14px; color:#5d4037;">Tu cita ha sido reprogramada con los siguientes datos:</p>

        <div style="background:#f5f0eb; border-radius:10px; padding:16px; margin:16px 0;">
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">🐾 <strong>Mascota:</strong> {{ $cita->mascota->nombre }}</p>
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">✂️ <strong>Servicio:</strong> {{ $cita->servicio->nombre }}</p>
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">📅 <strong>Nueva fecha:</strong> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}</p>
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">🕐 <strong>Nueva hora:</strong> {{ $cita->fecha_hora_inicio->format('H:i') }}</p>
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">👤 <strong>Groomer:</strong> {{ $cita->groomer?->nombre ?? 'Por asignar' }}</p>
        </div>

        <p style="font-size:13px; color:#a1887f;">Si tienes alguna consulta, contáctanos.</p>
        <p style="font-size:13px; color:#a1887f;">¡Gracias por confiar en Pet Spa! 🐾</p>
    </div>
</div>
</body>
</html>