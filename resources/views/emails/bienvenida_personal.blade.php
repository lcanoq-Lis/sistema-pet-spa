<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al equipo</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f4f4; padding:30px;">
    <div style="background:white; max-width:500px; margin:auto; padding:30px; border-radius:10px;">
        <h2 style="color:#2d6a4f;">🐾 Bienvenido a Pet Spa, {{ $nombre }}!</h2>
        <p>El administrador ha creado tu cuenta como <strong>{{ ucfirst($rol) }}</strong>.</p>
        <p>Tus credenciales de acceso son:</p>
        <div style="background:#f4f4f4; padding:15px; border-radius:8px; margin:20px 0;">
            <p><strong>Email:</strong> {{ $email }}</p>
            <p><strong>Contraseña temporal:</strong> {{ $password }}</p>
        </div>
        <p>Por seguridad, cambia tu contraseña después de iniciar sesión.</p>
        <a href="http://127.0.0.1:8000/login"
            style="display:inline-block; background:#2563eb; color:white; padding:12px 24px;
                   border-radius:8px; text-decoration:none; margin:10px 0;">
            Iniciar sesión
        </a>
        <p style="color:#888; font-size:12px;">Si no esperabas este mensaje, ignóralo.</p>
    </div>
</body>
</html>