<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recuperar contraseña</title>
</head>
<body style="font-family:Arial,sans-serif; background:#f4f4f4; padding:30px;">
    <div style="background:white; max-width:500px; margin:auto; padding:30px; border-radius:10px;">
        <h2 style="color:#ff7043;">🔐 Recuperar contraseña - Pet Spa</h2>
        <p>Hola <strong>{{ $nombre }}</strong>,</p>
        <p>Recibimos una solicitud para restablecer tu contraseña.</p>
        <a href="{{ $url }}"
            style="display:inline-block; background:linear-gradient(135deg,#ff7043,#ff8f00); color:white; padding:12px 24px; border-radius:8px; text-decoration:none; margin:20px 0; font-weight:bold;">
            Restablecer contraseña
        </a>
        <p style="color:#888; font-size:12px;">Este link expira en <strong>15 minutos</strong>.<br>Si no solicitaste esto, ignora este mensaje.</p>
    </div>
</body>
</html>