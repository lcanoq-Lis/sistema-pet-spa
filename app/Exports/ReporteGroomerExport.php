<?php

namespace App\Exports;

use App\Models\Cita;
use App\Models\Groomer;
use App\Models\InsumoGrooming;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReporteGroomerExport implements WithMultipleSheets
{
    public function __construct(public int $userId, public int $mes, public int $anio) {}

    public function sheets(): array
    {
        return [
            new GroomerCitasSheetInline($this->userId, $this->mes, $this->anio),
            new GroomerInsumosSheetInline($this->userId, $this->mes, $this->anio),
        ];
    }
}

// --- HOJA 1: CITAS DEL MES ---
class GroomerCitasSheetInline implements FromCollection, WithTitle, WithHeadings
{
    public function __construct(private int $userId, private int $mes, private int $anio) {}

    public function title(): string
    {
        return 'Citas del Mes';
    }

    public function headings(): array
    {
        return ['Mascota', 'Servicio', 'Fecha y Hora', 'Estado', 'Precio Acordado (Bs.)'];
    }

    public function collection()
    {
        $groomer = Groomer::where('usuario_id', $this->userId)->first();
        if (!$groomer) return collect([]);

        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin    = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        return Cita::where('groomer_id', $groomer->id)
            ->whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->with(['mascota', 'servicio'])
            ->orderBy('fecha_hora_inicio')
            ->get()
            ->map(function ($cita) {
                return [
                    'mascota'  => $cita->mascota->nombre ?? '—',
                    'servicio' => $cita->servicio->nombre ?? '—',
                    'fecha'    => $cita->fecha_hora_inicio?->format('d/m/Y H:i') ?? '—',
                    'estado'   => ucfirst($cita->estado),
                    'precio'   => number_format($cita->precio_acordado, 2),
                ];
            });
    }
}

// --- HOJA 2: INSUMOS UTILIZADOS ---
class GroomerInsumosSheetInline implements FromCollection, WithTitle, WithHeadings
{
    public function __construct(private int $userId, private int $mes, private int $anio) {}

    public function title(): string
    {
        return 'Insumos Utilizados';
    }

    public function headings(): array
    {
        return ['Insumo / Producto', 'Cantidad Consumida', 'Unidad de Medida'];
    }

    public function collection()
    {
        $groomer = Groomer::where('usuario_id', $this->userId)->first();
        if (!$groomer) return collect([]);

        $inicio = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin    = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        $insumosUsados = InsumoGrooming::whereHas('ficha', function ($q) use ($groomer, $inicio, $fin) {
                $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id));
            })
            ->whereBetween('creado_en', [$inicio, $fin])
            ->where('estado', '!=', 'devuelto')
            ->with('producto')
            ->get();

        return $insumosUsados->groupBy('producto_id')->map(function ($items) {
            return [
                'nombre'   => $items->first()->producto->nombre ?? '—',
                'cantidad' => $items->sum('cantidad'),
                'unidad'   => $items->first()->unidad,
            ];
        })->values();
    }
}