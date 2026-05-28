<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif; background:#f5f5f5; padding:20px;">
<div style="max-width:500px; margin:0 auto; background:white; border-radius:12px; overflow:hidden;">
    <div style="background:linear-gradient(135deg,#c62828,#e53935); padding:24px; text-align:center;">
        <div style="font-size:40px;">⚠️</div>
        <h2 style="color:white; margin:8px 0 0;">Alto consumo de insumos</h2>
        <p style="color:rgba(255,255,255,0.85); font-size:13px;">Pet Spa — Alerta automática</p>
    </div>
    <div style="padding:24px;">
        <p style="font-size:14px; color:#5d4037;">El groomer <strong>{{ $groomer->nombre }}</strong> ha superado el límite de consumo de insumos esta semana.</p>
        <div style="background:#fff5f5; border-radius:10px; padding:16px; margin:16px 0; border-left:4px solid #e53935;">
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">✂️ <strong>Groomer:</strong> {{ $groomer->nombre }}</p>
            <p style="margin:4px 0; font-size:13px; color:#5d4037;">📦 <strong>Insumos usados esta semana:</strong> {{ $total }} unidades</p>
            <p style="margin:4px 0; font-size:13px; color:#c62828;">⚠️ <strong>Límite configurado:</strong> {{ $limite }} unidades</p>
        </div>
        <p style="font-size:13px; color:#a1887f;">Revisa el detalle en el panel de administración.</p>
    </div>
</div>
</body>
</html>