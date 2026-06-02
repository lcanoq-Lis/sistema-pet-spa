<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido al equipo - Pet Spa</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#F5F5F0; padding:30px; margin:0;">
    <div style="max-width:550px; margin:0 auto; background:white; border-radius:24px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        
        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#2E7D32,#43A047); padding:28px 24px; text-align:center;">
            <div style="background:rgba(255,255,255,0.2); width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                <i style="font-size:28px; color:white;">🐾</i>
            </div>
            <h2 style="color:white; margin:12px 0 4px; font-size:20px; font-weight:700;">¡Bienvenido a Pet Spa!</h2>
            <p style="color:rgba(255,255,255,0.85); font-size:12px; margin:0;">Tu cuenta ha sido creada exitosamente</p>
        </div>
        
        {{-- Body --}}
        <div style="padding:28px;">
            <p style="font-size:14px; color:#5D4037; margin:0 0 8px; line-height:1.5;">
                Hola <strong style="color:#2E7D32;">{{ $nombre }}</strong>,
            </p>
            <p style="font-size:14px; color:#5D4037; margin:0 0 20px;">
                El administrador ha creado tu cuenta como <strong style="color:#2E7D32;">{{ ucfirst($rol) }}</strong>.
            </p>
            
            {{-- Credenciales --}}
            <div style="background:#E8F5E9; border-radius:16px; padding:18px; margin:20px 0;">
                <p style="font-size:13px; font-weight:700; color:#2E7D32; margin:0 0 12px; text-align:center;">📋 Tus credenciales de acceso</p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037;">
                    <strong>📧 Email:</strong> {{ $email }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037;">
                    <strong>🔐 Contraseña temporal:</strong> <span style="background:white; padding:4px 8px; border-radius:8px; font-family:monospace;">{{ $password }}</span>
                </p>
            </div>
            
            {{-- Advertencia --}}
            <p style="font-size:12px; color:#F57F17; margin:16px 0; display:flex; align-items:center; gap:6px; background:#FFF8E1; padding:10px 14px; border-radius:12px;">
                <span>⚠️</span> Por seguridad, cambia tu contraseña después de iniciar sesión.
            </p>
            
            {{-- Botón --}}
            <div style="text-align:center; margin:24px 0 16px;">
                <a href="http://127.0.0.1:8000/login"
                    style="display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#2E7D32,#43A047); color:white; padding:12px 28px; border-radius:40px; text-decoration:none; font-size:13px; font-weight:600;">
                    🚪 Iniciar sesión
                </a>
            </div>
            
            {{-- Footer --}}
            <p style="color:#A1887F; font-size:11px; margin:16px 0 0; text-align:center;">
                Si no esperabas este mensaje, por favor ignóralo.
            </p>
        </div>
    </div>
</body>
</html>