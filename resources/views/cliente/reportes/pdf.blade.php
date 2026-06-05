<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1A2E1A; margin: 0; padding: 20px; }
        h1 { font-size: 18px; color: #2E7D32; margin: 0 0 4px; }
        h2 { font-size: 13px; color: #4F6B4F; margin: 0 0 20px; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #2E7D32; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 8px 10px; border-bottom: 1px solid #F0F0EA; font-size: 11px; }
        tr:nth-child(even) td { background: #FAFBF7; }
        .section-title { font-size: 13px; font-weight: bold; color: #2E7D32; margin: 16px 0 8px; border-bottom: 2px solid #2E7D32; padding-bottom: 4px; }
        .footer { margin-top: 30px; text-align: center; color: #8A9B8A; font-size: 10px; border-top: 1px solid #e0e0e0; padding-top: 10px; }
    </style>
</head>
<body>
    <h1>Pet Spa — Mi Historial</h1>
    <h2>{{ $cliente->nombre }} {{ $cliente->apellido }} · Generado el {{ now()->format('d/m/Y H:i') }}</h2>

    <div class="section-title">Resumen</div>
    <table>
        <tr><th>Indicador</th><th>Valor</th></tr>
        <tr><td>Citas completadas</td><td>{{ $totalCitas }}</td></tr>
        <tr><td>Total invertido</td><td>Bs. {{ number_format($totalGastado, 2) }}</td></tr>
        <tr><td>Puntos acumulados</td><td>{{ number_format($puntosTotales) }}</td></tr>
        <tr><td>Servicio favorito</td><td>{{ $servicioFavoritoNombre }}</td></tr>
    </table>

    <div class="section-title">Historial de Citas</div>
    @if($historial->isEmpty())
        <p style="color:#8A9B8A;">Sin historial aún.</p>
    @else
    <table>
        <tr><th>Mascota</th><th>Servicio</th><th>Fecha</th><th>Estado</th><th>Total</th></tr>
        @foreach($historial as $cita)
        <tr>
            <td>{{ $cita->mascota->nombre ?? '—' }}</td>
            <td>{{ $cita->servicio->nombre ?? '—' }}</td>
            <td>{{ $cita->fecha_hora_inicio?->format('d/m/Y H:i') }}</td>
            <td>{{ ucfirst($cita->estado) }}</td>
            <td>{{ $cita->estado === 'completada' ? 'Bs. ' . number_format($cita->pago?->total ?? $cita->precio_acordado, 2) : '—' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <div class="section-title">Mascotas</div>
    <table>
        <tr><th>Nombre</th><th>Especie</th><th>Raza</th><th>Edad</th></tr>
        @foreach($mascotas as $mascota)
        <tr>
            <td>{{ $mascota->nombre }}</td>
            <td>{{ $mascota->especie }}</td>
            <td>{{ $mascota->raza ?? '—' }}</td>
            <td>{{ $mascota->edad() }}</td>
        </tr>
        @endforeach
    </table>

    <div class="footer">Pet Spa &mdash; Reporte generado automáticamente</div>
</body>
</html>
