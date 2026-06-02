<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tu mascota está lista - Pet Spa</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#F5F5F0; padding:20px; margin:0;">
    <div style="max-width:550px; margin:0 auto; background:white; border-radius:24px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        
        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#2E7D32,#43A047); padding:28px 24px; text-align:center;">
            <div style="background:rgba(255,255,255,0.2); width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                <i style="font-size:28px; color:white;">🎉</i>
            </div>
            <h2 style="color:white; margin:12px 0 4px; font-size:20px; font-weight:700;">¡Tu mascota está lista!</h2>
            <p style="color:rgba(255,255,255,0.85); font-size:12px; margin:0;">Pet Spa — Servicio completado</p>
        </div>
        
        {{-- Body --}}
        <div style="padding:28px;">
            <p style="font-size:14px; color:#5D4037; margin:0 0 8px; line-height:1.5;">
                Hola <strong style="color:#2E7D32;">{{ $cliente->name }}</strong>,
            </p>
            <p style="font-size:14px; color:#5D4037; margin:0 0 20px;">
                El servicio de <strong style="color:#2E7D32;">{{ $cita->mascota->nombre }}</strong> ha finalizado. ¡Ya puedes pasar a recogerlo!
            </p>
            
            {{-- Detalles del servicio --}}
            <div style="background:#E8F5E9; border-radius:16px; padding:18px; margin:20px 0;">
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>🐾</span> <strong>Mascota:</strong> {{ $cita->mascota->nombre }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>✂️</span> <strong>Servicio:</strong> {{ $cita->servicio->nombre }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>👤</span> <strong>Groomer:</strong> {{ $cita->groomer?->nombre ?? '—' }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>🕐</span> <strong>Finalizado:</strong> {{ now()->format('d/m/Y H:i') }}
                </p>
                @if($ficha->estado_final)
                <p style="margin:8px 0 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px; padding-top:8px; border-top:1px solid #C8E6C9;">
                    <span>📝</span> <strong>Estado final:</strong> {{ $ficha->estado_final }}
                </p>
                @endif
            </div>
            
            {{-- Footer --}}
            <p style="font-size:13px; color:#2E7D32; margin:20px 0 0; text-align:center; font-weight:500;">
                🐾 ¡Gracias por confiar en Pet Spa!
            </p>
        </div>
    </div>
</body>
</html>