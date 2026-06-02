<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $pago->id }} — Pet Spa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: #F5F5F0; display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 30px; }
        .factura { background: #fff; width: 540px; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 35px -10px rgba(0,0,0,0.1); border: 0.5px solid #e0e0e0; }
        .header { background: linear-gradient(135deg, #1B5E20, #0D3B0D); padding: 28px 32px; text-align: center; }
        .header h1 { font-size: 24px; color: #fff; font-weight: 800; letter-spacing: -0.3px; margin: 0; }
        .header p { font-size: 13px; color: rgba(255,255,255,0.8); margin-top: 6px; }
        .badge { display: inline-block; background: rgba(255,255,255,0.15); color: #fff; font-size: 12px; font-weight: 700; padding: 4px 16px; border-radius: 30px; margin-top: 12px; letter-spacing: 0.5px; }
        .body { padding: 28px 32px; }
        .section-title { font-size: 11px; font-weight: 700; color: #4A7A4A; text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px; }
        .section-title i { font-size: 13px; }
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 24px; }
        .info-item label { font-size: 11px; color: #8A9B8A; font-weight: 600; display: flex; align-items: center; gap: 4px; margin-bottom: 4px; }
        .info-item label i { font-size: 12px; }
        .info-item p { font-size: 14px; color: #1A2E1A; font-weight: 600; margin: 0; }
        .linea { border: none; border-top: 1px solid #F0F0EA; margin: 20px 0; }
        .totales { background: #F9FBF6; border-radius: 16px; padding: 18px 22px; margin-bottom: 24px; border: 1px solid #E0E5D9; }
        .fila-total { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; font-size: 14px; color: #1A2E1A; }
        .fila-total.grande { font-size: 18px; font-weight: 800; color: #1B5E20; border-top: 1px solid #E0E5D9; padding-top: 12px; margin-top: 8px; }
        .metodo { display: flex; align-items: center; gap: 14px; background: #F9FBF6; border: 1.5px solid #E0E5D9; border-radius: 14px; padding: 14px 18px; margin-bottom: 24px; }
        .metodo .icono { width: 44px; height: 44px; background: #fff; border-radius: 12px; display: flex; align-items: center; justify-content: center; border: 1px solid #E0E5D9; }
        .metodo .icono i { font-size: 24px; color: #1B5E20; }
        .metodo p { font-size: 14px; font-weight: 700; color: #1A2E1A; margin: 0; }
        .metodo small { font-size: 12px; color: #8A9B8A; display: block; margin-top: 2px; }
        .footer { background: #F5F5F0; padding: 18px 32px; text-align: center; border-top: 1px solid #E0E5D9; }
        .footer p { font-size: 12px; color: #8A9B8A; margin: 0; }
        .footer p:first-child { font-weight: 600; color: #4A7A4A; margin-bottom: 4px; }
        .btn-imprimir { display: block; margin: 20px auto 0; background: linear-gradient(135deg, #1B5E20, #0D3B0D); color: #fff; font-weight: 700; padding: 12px 32px; border-radius: 40px; border: none; cursor: pointer; font-size: 14px; font-family: inherit; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-imprimir:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(27,94,32,0.2); }
        .btn-volver { background: #fff; border: 1.5px solid #e0e0e0; color: #5D6E5D; font-weight: 600; padding: 12px 28px; border-radius: 40px; text-decoration: none; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s; }
        .btn-volver:hover { background: #F5F5F0; }
        @media print {
            body { background: #fff; padding: 0; }
            .factura { box-shadow: none; border-radius: 0; border: none; }
            .btn-imprimir, .btn-volver { display: none; }
            .header { background: #1B5E20; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .metodo .icono { background: #F9FBF6; }
        }
    </style>
</head>
<body>
<div class="factura">
    <div class="header">
        <i class="ti ti-paw" style="font-size: 42px; color: rgba(255,255,255,0.9); margin-bottom: 8px; display: inline-block;"></i>
        <h1>Pet Spa</h1>
        <p>Comprobante de pago oficial</p>
        <span class="badde">FACTURA #{{ str_pad($pago->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>

    <div class="body">
        <div class="section-title">
            <i class="ti ti-clipboard-list"></i> Datos del servicio
        </div>
        <div class="info-grid">
            <div class="info-item">
                <label><i class="ti ti-dog"></i> Mascota</label>
                <p>{{ $pago->cita->mascota->nombre }}</p>
            </div>
            <div class="info-item">
                <label><i class="ti ti-info-circle"></i> Especie / Raza</label>
                <p>{{ ucfirst($pago->cita->mascota->especie) }} · {{ $pago->cita->mascota->raza }}</p>
            </div>
            <div class="info-item">
                <label><i class="ti ti-scissors"></i> Servicio</label>
                <p>{{ $pago->cita->servicio->nombre }}</p>
            </div>
            <div class="info-item">
                <label><i class="ti ti-calendar"></i> Fecha del servicio</label>
                <p>{{ $pago->cita->fecha_hora_inicio->format('d/m/Y H:i') }}</p>
            </div>
            <div class="info-item">
                <label><i class="ti ti-user"></i> Groomer</label>
                <p>{{ $pago->cita->groomer?->nombre ?? 'No asignado' }}</p>
            </div>
            <div class="info-item">
                <label><i class="ti ti-cash"></i> Fecha de pago</label>
                <p>{{ $pago->creado_en->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <hr class="linea">
        
        <div class="section-title">
            <i class="ti ti-credit-card"></i> Método de pago
        </div>
        <div class="metodo">
            <div class="icono">
                @if($pago->metodo === 'efectivo')
                    <i class="ti ti-cash"></i>
                @elseif($pago->metodo === 'qr')
                    <i class="ti ti-qrcode"></i>
                @else
                    <i class="ti ti-transfer"></i>
                @endif
            </div>
            <div>
                <p>{{ $pago->metodo_label }}</p>
                @if($pago->referencia)
                    <small><i class="ti ti-hash" style="font-size: 10px;"></i> Ref: {{ $pago->referencia }}</small>
                @endif
            </div>
        </div>

        <div class="section-title">
            <i class="ti ti-receipt"></i> Detalle del cobro
        </div>
        <div class="totales">
            <div class="fila-total">
                <span>Subtotal</span>
                <span>Bs. {{ number_format($pago->monto, 2) }}</span>
            </div>
            @if($pago->descuento > 0)
            <div class="fila-total" style="color: #E65100;">
                <span><i class="ti ti-discount" style="font-size: 12px;"></i> Descuento</span>
                <span>- Bs. {{ number_format($pago->descuento, 2) }}</span>
            </div>
            @endif
            <div class="fila-total grande">
                <span>TOTAL PAGADO</span>
                <span>Bs. {{ number_format($pago->total, 2) }}</span>
            </div>
        </div>

        @if($pago->observaciones)
        <div class="section-title">
            <i class="ti ti-notes"></i> Observaciones
        </div>
        <p style="font-size: 13px; color: #6B8F6B; margin-bottom: 20px; background: #F9FBF6; padding: 12px 16px; border-radius: 12px;">
            {{ $pago->observaciones }}
        </p>
        @endif
    </div>

    <div class="footer">
        <p>¡Gracias por confiar en Pet Spa!</p>
        <p>Registrado por: {{ $pago->registradoPor?->name ?? 'Sistema' }}</p>
    </div>
</div>

<div style="text-align:center; margin-top: 24px; display:flex; gap: 16px; justify-content:center;">
    <a href="{{ route('recepcion.pagos.index') }}" class="btn-volver">
        <i class="ti ti-arrow-left" style="font-size: 14px;"></i> Volver
    </a>
    <button onclick="window.print()" class="btn-imprimir">
        <i class="ti ti-printer" style="font-size: 14px;"></i> Imprimir factura
    </button>
</div>
</body>
</html>
