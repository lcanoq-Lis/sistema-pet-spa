<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Activa tu cuenta</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:30px;">
    <div style="background:white; max-width:500px; margin:auto; padding:30px; border-radius:10px;">
        <h2 style="color:#2d6a4f;">🐾 Bienvenido a Pet Spa, {{ $nombre }}!</h2>
        <p>Gracias por registrarte. Para activar tu cuenta haz clic en el botón:</p>
        <a href="{{ $url }}"
            style="display:inline-block; background:#2563eb; color:white; padding:12px 24px;
                   border-radius:8px; text-decoration:none; margin:20px 0;">
            Activar mi cuenta
        </a>
        <p style="color:#888; font-size:12px;">
            Este enlace expira en <strong>15 minutos</strong>.<br>
            Si no creaste esta cuenta, ignora este mensaje.
        </p>
    </div>
</body>
</html>