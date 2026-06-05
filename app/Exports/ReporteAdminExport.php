<?php

namespace App\Exports;

use App\Models\Cita;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteAdminExport implements WithMultipleSheets
{
    public function __construct(public int $mes, public int $anio) {}

    public function sheets(): array
    {
        return [
            'Ranking Servicios' => new RankingServiciosSheet($this->mes, $this->anio),
            'Citas por Estado'  => new CitasEstadoSheet(),
            'Ingresos 6 meses'  => new IngresosMesesSheet(),
        ];
    }
}

class RankingServiciosSheet implements FromCollection, WithHeadings
{
    public function __construct(public int $mes, public int $anio) {}

    public function headings(): array
    {
        return ['#', 'Servicio', 'Citas', 'Ingresos (Bs.)', 'Promedio/cita (Bs.)'];
    }

    public function collection()
    {
        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin    = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        return Cita::selectRaw('servicio_id, COUNT(*) as total_citas, SUM(precio_acordado) as ingresos')
            ->where('estado', 'completada')
            ->whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->with('servicio')
            ->groupBy('servicio_id')
            ->orderByDesc('ingresos')
            ->get()
            ->map(fn($item, $i) => [
                $i + 1,
                $item->servicio?->nombre ?? '—',
                $item->total_citas,
                number_format($item->ingresos, 2),
                $item->total_citas > 0 ? number_format($item->ingresos / $item->total_citas, 2) : '0.00',
            ]);
    }
}

class CitasEstadoSheet implements FromCollection, WithHeadings
{
    public function headings(): array { return ['Estado', 'Total']; }

    public function collection()
    {
        return Cita::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->get()
            ->map(fn($row) => [ucfirst(str_replace('_', ' ', $row->estado)), $row->total]);
    }
}

class IngresosMesesSheet implements FromCollection, WithHeadings
{
    public function headings(): array { return ['Mes', 'Ingresos (Bs.)']; }

    public function collection()
    {
        return collect(range(5, 0))->map(function ($i) {
            $fecha = now()->subMonths($i);
            return [
                ucfirst($fecha->locale('es')->monthName . ' ' . $fecha->year),
                number_format(Cita::where('estado', 'completada')->whereYear('fecha_hora_inicio', $fecha->year)->whereMonth('fecha_hora_inicio', $fecha->month)->sum('precio_acordado'), 2),
            ];
        });
    }
}
