<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1A2E1A; margin: 0; padding: 20px; }
        h1 { font-size: 18px; color: #2E7D32; margin: 0 0 4px; }
        h2 { font-size: 13px; color: #4F6B4F; margin: 0 0 20px; font-weight: normal; }
        .kpi-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
        .kpi { border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; min-width: 130px; text-align: center; }
        .kpi-val { font-size: 22px; font-weight: bold; color: #2E7D32; }
        .kpi-label { font-size: 10px; color: #8A9B8A; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #2E7D32; color: white; padding: 8px 10px; text-align: left; font-size: 11px; }
        td { padding: 8px 10px; border-bottom: 1px solid #F0F0EA; font-size: 11px; }
        tr:nth-child(even) td { background: #FAFBF7; }
        .section-title { font-size: 13px; font-weight: bold; color: #2E7D32; margin: 16px 0 8px; border-bottom: 2px solid #2E7D32; padding-bottom: 4px; }
        .footer { margin-top: 30px; text-align: center; color: #8A9B8A; font-size: 10px; border-top: 1px solid #e0e0e0; padding-top: 10px; }
    </style>
</head>
<body>
    <h1>Pet Spa — Reporte Ejecutivo</h1>
    <h2>{{ ucfirst($meses->firstWhere('numero', $mes)['nombre'] ?? '') }} {{ $anio }} · Generado el {{ now()->format('d/m/Y H:i') }}</h2>

    <div class="section-title">Resumen General</div>
    <table>
        <tr><th>Indicador</th><th>Valor</th></tr>
        <tr><td>Clientes registrados</td><td>{{ $totalClientes }}</td></tr>
        <tr><td>Citas hoy</td><td>{{ $citasHoy }}</td></tr>
        <tr><td>Citas este mes</td><td>{{ $citasMes }}</td></tr>
        <tr><td>Groomers activos</td><td>{{ $totalGroomers }}</td></tr>
        <tr><td>Citas completadas</td><td>{{ $citasCompletadas }}</td></tr>
        <tr><td>Citas canceladas</td><td>{{ $citasCanceladas }} ({{ $tasaCancelacion }}%)</td></tr>
        <tr><td>Productos bajo stock</td><td>{{ $productosBajoStock }}</td></tr>
        <tr><td>Ingresos este mes</td><td>Bs. {{ number_format($ingresosMes, 2) }}</td></tr>
    </table>

    <div class="section-title">Ranking de Rentabilidad</div>
    @if($rankingServicios->isEmpty())
        <p style="color:#8A9B8A;">Sin datos para este período.</p>
    @else
    <table>
        <tr><th>#</th><th>Servicio</th><th>Citas</th><th>Ingresos</th><th>Promedio/cita</th></tr>
        @foreach($rankingServicios as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->servicio?->nombre ?? '—' }}</td>
            <td>{{ $item->total_citas }}</td>
            <td>Bs. {{ number_format($item->ingresos, 2) }}</td>
            <td>Bs. {{ $item->total_citas > 0 ? number_format($item->ingresos / $item->total_citas, 2) : '0.00' }}</td>
        </tr>
        @endforeach
    </table>
    @endif

    <div class="section-title">Ingresos Últimos 6 Meses</div>
    <table>
        <tr><th>Mes</th><th>Ingresos</th></tr>
        @foreach($ingresosPorMes as $item)
        <tr><td style="text-transform:capitalize;">{{ $item['mes'] }}</td><td>Bs. {{ number_format($item['ingresos'], 2) }}</td></tr>
        @endforeach
    </table>

    <div class="section-title">Citas por Estado</div>
    <table>
        <tr><th>Estado</th><th>Total</th></tr>
        @foreach($citasPorEstado as $estado => $cantidad)
        <tr><td>{{ ucfirst(str_replace('_', ' ', $estado)) }}</td><td>{{ $cantidad }}</td></tr>
        @endforeach
    </table>

    <div class="footer">Pet Spa &mdash; Reporte generado automáticamente</div>
</body>
</html>
