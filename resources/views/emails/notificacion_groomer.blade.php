<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva cita asignada - Pet Spa</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#F5F5F0; padding:30px; margin:0;">
    <div style="max-width:550px; margin:0 auto; background:white; border-radius:24px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#2E7D32,#43A047); padding:28px 24px; text-align:center;">
            <div style="background:rgba(255,255,255,0.2); width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                <i style="font-size:28px; color:white;">📅</i>
            </div>
            <h2 style="color:white; margin:12px 0 4px; font-size:20px; font-weight:700;">Nueva cita asignada</h2>
            <p style="color:rgba(255,255,255,0.85); font-size:12px; margin:0;">Pet Spa — Revisa los detalles</p>
        </div>

        {{-- Body --}}
        <div style="padding:28px;">
            <p style="font-size:14px; color:#5D4037; margin:0 0 8px; line-height:1.5;">
                Hola <strong style="color:#2E7D32;">{{ $groomer->nombre }}</strong>,
            </p>
            <p style="font-size:14px; color:#5D4037; margin:0 0 20px;">
                Se te ha asignado una nueva cita con los siguientes detalles:
            </p>

            {{-- Detalles de la cita --}}
            <div style="background:#E8F5E9; border-radius:16px; padding:18px; margin:20px 0;">
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>🐾</span> <strong>Mascota:</strong> {{ $cita->mascota->nombre }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>🐕</span> <strong>Especie:</strong> {{ ucfirst($cita->mascota->especie) }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>✂️</span> <strong>Servicio:</strong> {{ $cita->servicio->nombre }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>📅</span> <strong>Fecha:</strong> {{ $cita->fecha_hora_inicio->format('d/m/Y') }}
                </p>
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span>🕐</span> <strong>Hora:</strong> {{ $cita->fecha_hora_inicio->format('H:i') }} — {{ $cita->fecha_hora_fin_estimada->format('H:i') }}
                </p>

                @if($cita->mascota->alergias)
                <p style="margin:8px 0; font-size:13px; color:#E65100; display:flex; align-items:center; gap:8px; background:#FFF3E0; padding:8px 12px; border-radius:12px;">
                    <span>⚠️</span> <strong>Alergias:</strong> {{ $cita->mascota->alergias }}
                </p>
                @endif

                @if($cita->mascota->restricciones_medicas)
                <p style="margin:8px 0; font-size:13px; color:#E65100; display:flex; align-items:center; gap:8px; background:#FFF3E0; padding:8px 12px; border-radius:12px;">
                    <span>⚠️</span> <strong>Restricciones:</strong> {{ $cita->mascota->restricciones_medicas }}
                </p>
                @endif

                @if($cita->notas_cliente)
                <p style="margin:8px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px; padding-top:8px; border-top:1px solid #C8E6C9;">
                    <span>📝</span> <strong>Notas del cliente:</strong> {{ $cita->notas_cliente }}
                </p>
                @endif
            </div>

            {{-- Footer --}}
            <p style="color:#A1887F; font-size:11px; margin:20px 0 0; text-align:center;">
                🐾 Pet Spa — Por favor confirma o cancela la cita desde tu panel
            </p>
        </div>
    </div>
</body>
</html>