<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Alerta de consumo de insumos - Pet Spa</title>
</head>
<body style="font-family: 'Segoe UI', Arial, sans-serif; background:#F5F5F0; padding:20px; margin:0;">
    <div style="max-width:550px; margin:0 auto; background:white; border-radius:24px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.05);">
        
        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#C62828,#E53935); padding:28px 24px; text-align:center;">
            <div style="background:rgba(255,255,255,0.2); width:56px; height:56px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto;">
                <i style="font-size:28px; color:white;">⚠️</i>
            </div>
            <h2 style="color:white; margin:12px 0 4px; font-size:20px; font-weight:700;">Alto consumo de insumos</h2>
            <p style="color:rgba(255,255,255,0.85); font-size:12px; margin:0;">Pet Spa — Alerta automática</p>
        </div>
        
        {{-- Body --}}
        <div style="padding:28px;">
            <p style="font-size:14px; color:#5D4037; margin:0 0 16px; line-height:1.5;">
                El groomer <strong style="color:#C62828;">{{ $groomer->nombre }}</strong> ha superado el límite de consumo de insumos esta semana.
            </p>
            
            {{-- Detalles --}}
            <div style="background:#FFF5F5; border-radius:16px; padding:18px; margin:20px 0; border-left:4px solid #E53935;">
                <p style="margin:6px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span style="font-size:16px;">✂️</span> <strong>Groomer:</strong> {{ $groomer->nombre }}
                </p>
                <p style="margin:6px 0; font-size:13px; color:#5D4037; display:flex; align-items:center; gap:8px;">
                    <span style="font-size:16px;">📦</span> <strong>Insumos usados esta semana:</strong> {{ $total }} unidades
                </p>
                <p style="margin:6px 0; font-size:13px; color:#C62828; display:flex; align-items:center; gap:8px;">
                    <span style="font-size:16px;">⚠️</span> <strong>Límite configurado:</strong> {{ $limite }} unidades
                </p>
            </div>
            
            {{-- Footer --}}
            <p style="font-size:12px; color:#A1887F; margin:16px 0 0; text-align:center;">
                Revisa el detalle en el panel de administración de Pet Spa.
            </p>
        </div>
    </div>
</body>
</html>