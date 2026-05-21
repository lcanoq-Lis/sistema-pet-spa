<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $pago->id }} — Pet Spa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; background: #f5f5f5; display: flex; justify-content: center; padding: 30px; }
        .factura { background: white; width: 520px; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.12); }
        .header { background: linear-gradient(135deg, #ff7043, #ff8f00); padding: 28px 32px; text-align: center; }
        .header h1 { font-size: 22px; color: white; font-weight: 700; }
        .header p { font-size: 13px; color: rgba(255,255,255,0.85); margin-top: 4px; }
        .badge { display: inline-block; background: rgba(255,255,255,0.2); color: white; font-size: 12px; font-weight: 600; padding: 4px 14px; border-radius: 20px; margin-top: 10px; }
        .body { padding: 28px 32px; }
        .section-title { font-size: 11px; font-weight: 700; color: #a1887f; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 24px; }
        .info-item label { font-size: 11px; color: #a1887f; font-weight: 600; display: block; margin-bottom: 2px; }
        .info-item p { font-size: 14px; color: #5d4037; font-weight: 600; }
        .linea { border: none; border-top: 1px solid #f5f0eb; margin: 20px 0; }
        .totales { background: #f5f0eb; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; }
        .fila-total { display: flex; justify-content: space-between; align-items: center; padding: 4px 0; font-size: 14px; color: #5d4037; }
        .fila-total.grande { font-size: 18px; font-weight: 700; color: #ff7043; border-top: 1px solid #d7ccc8; padding-top: 10px; margin-top: 6px; }
        .metodo { display: flex; align-items: center; gap: 10px; background: #fff8f5; border: 2px solid #ffd0b5; border-radius: 10px; padding: 12px 16px; margin-bottom: 24px; }
        .metodo .icono { font-size: 28px; }
        .metodo p { font-size: 14px; font-weight: 600; color: #5d4037; }
        .metodo small { font-size: 12px; color: #a1887f; display: block; }
        .footer { background: #f5f0eb; padding: 18px 32px; text-align: center; }
        .footer p { font-size: 12px; color: #a1887f; }
        .btn-imprimir { display: block; margin: 20px auto 0; background: linear-gradient(135deg,#ff7043,#ff8f00); color: white; font-weight: 700; padding: 10px 28px; border-radius: 10px; border: none; cursor: pointer; font-size: 14px; font-family: Arial, sans-serif; }
        @media print {
            body { background: white; padding: 0; }
            .factura { box-shadow: none; border-radius: 0; }
            .btn-imprimir { display: none; }
            .btn-volver { display: none; }
        }
    </style>
</head>
<body>
<div class="factura">
    <div class="header">
        <div style="font-size: 36px; margin-bottom: 8px;">🐾</div>
        <h1>Pet Spa</h1>
        <p>Comprobante de pago</p>
        <span class="badge">FACTURA #{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>

    <div class="body">
        <p class="section-title">Datos del servicio</p>
        <div class="info-grid">
            <div class="info-item">
                <label>Mascota</label>
                <p>{{ $pago->cita->mascota->nombre }}</p>
            </div>
            <div class="info-item">
                <label>Especie / Raza</label>
                <p>{{ ucfirst($pago->cita->mascota->especie) }} · {{ $pago->cita->mascota->raza }}</p>
            </div>
            <div class="info-item">
                <label>Servicio</label>
                <p>{{ $pago->cita->servicio->nombre }}</p>
            </div>
            <div class="info-item">
                <label>Fecha del servicio</label>
                <p>{{ $pago->cita->fecha_hora_inicio->format('d/m/Y H:i') }}</p>
            </div>
            <div class="info-item">
                <label>Groomer</label>
                <p>{{ $pago->cita->groomer?->nombre ?? 'No asignado' }}</p>
            </div>
            <div class="info-item">
                <label>Fecha de pago</label>
                <p>{{ $pago->creado_en->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <hr class="linea">
        <p class="section-title">Método de pago</p>
        <div class="metodo">
            <div class="icono">{{ $pago->metodo_icono }}</div>
            <div>
                <p>{{ $pago->metodo_label }}</p>
                @if($pago->referencia)
                    <small>Ref: {{ $pago->referencia }}</small>
                @endif
            </div>
        </div>

        <p class="section-title">Detalle del cobro</p>
        <div class="totales">
            <div class="fila-total">
                <span>Subtotal</span>
                <span>Bs. {{ number_format($pago->monto, 2) }}</span>
            </div>
            @if($pago->descuento > 0)
            <div class="fila-total" style="color:#e65100;">
                <span>Descuento</span>
                <span>- Bs. {{ number_format($pago->descuento, 2) }}</span>
            </div>
            @endif
            <div class="fila-total grande">
                <span>TOTAL PAGADO</span>
                <span>Bs. {{ number_format($pago->total, 2) }}</span>
            </div>
        </div>

        @if($pago->observaciones)
        <p class="section-title">Observaciones</p>
        <p style="font-size:13px; color:#8d6e63; margin-bottom:20px;">{{ $pago->observaciones }}</p>
        @endif
    </div>

    <div class="footer">
        <p>Gracias por confiar en Pet Spa 🐾</p>
        <p style="margin-top:4px;">Registrado por: {{ $pago->registradoPor?->name ?? 'Sistema' }}</p>
    </div>
</div>

<div style="text-align:center; margin-top:16px; display:flex; gap:10px; justify-content:center;">
    <a href="{{ route('recepcion.pagos.index') }}" class="btn-volver"
        style="background:#f5f0eb; color:#5d4037; font-weight:600; padding:10px 24px; border-radius:10px; text-decoration:none; font-size:14px;">
        ← Volver
    </a>
    <button onclick="window.print()" class="btn-imprimir">🖨️ Imprimir factura</button>
</div>
</body>
</html>
