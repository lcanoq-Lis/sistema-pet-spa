<?php

namespace App\Exports;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Groomer;
use App\Models\InsumoGrooming;
use App\Models\PuntoCliente;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

// ── GROOMER ──────────────────────────────────────────────────────

class ReporteGroomerExport implements WithMultipleSheets
{
    public function __construct(public int $userId, public int $mes, public int $anio) {}

    public function sheets(): array
    {
        return [
            new GroomerCitasSheet($this->userId, $this->mes, $this->anio),
            new GroomerInsumosSheet($this->userId, $this->mes, $this->anio),
        ];
    }
}

class GroomerCitasSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(public int $userId, public int $mes, public int $anio) {}
    public function title(): string { return 'Citas'; }
    public function headings(): array { return ['Mascota', 'Servicio', 'Fecha', 'Estado', 'Precio (Bs.)']; }

    public function collection()
    {
        $groomer = Groomer::where('usuario_id', $this->userId)->first();
        $inicio  = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin     = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        return Cita::where('groomer_id', $groomer->id)
            ->whereBetween('fecha_hora_inicio', [$inicio, $fin])
            ->with(['mascota', 'servicio'])
            ->get()
            ->map(fn($c) => [
                $c->mascota->nombre ?? '—',
                $c->servicio->nombre ?? '—',
                $c->fecha_hora_inicio?->format('d/m/Y H:i'),
                ucfirst($c->estado),
                number_format($c->precio_acordado, 2),
            ]);
    }
}

class GroomerInsumosSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(public int $userId, public int $mes, public int $anio) {}
    public function title(): string { return 'Insumos'; }
    public function headings(): array { return ['Producto', 'Cantidad', 'Unidad', 'Estado']; }

    public function collection()
    {
        $groomer = Groomer::where('usuario_id', $this->userId)->first();
        $inicio  = Carbon::create($this->anio, $this->mes, 1)->startOfMonth();
        $fin     = Carbon::create($this->anio, $this->mes, 1)->endOfMonth();

        return InsumoGrooming::whereHas('ficha', fn($q) => $q->whereHas('cita', fn($q2) => $q2->where('groomer_id', $groomer->id)))
            ->whereBetween('creado_en', [$inicio, $fin])
            ->with('producto')
            ->get()
            ->map(fn($i) => [
                $i->producto->nombre ?? '—',
                $i->cantidad,
                $i->unidad,
                ucfirst($i->estado),
            ]);
    }
}

// ── CLIENTE ──────────────────────────────────────────────────────

class ReporteClienteExport implements WithMultipleSheets
{
    public function __construct(public int $userId) {}

    public function sheets(): array
    {
        return [
            new ClienteCitasSheet($this->userId),
            new ClientePuntosSheet($this->userId),
        ];
    }
}

class ClienteCitasSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(public int $userId) {}
    public function title(): string { return 'Historial Citas'; }
    public function headings(): array { return ['Mascota', 'Servicio', 'Fecha', 'Estado', 'Total (Bs.)']; }

    public function collection()
    {
        $cliente = Cliente::where('usuario_id', $this->userId)->first();
        return Cita::whereHas('mascota', fn($q) => $q->whereHas('duenos', fn($q2) => $q2->where('cliente_id', $cliente->id)))
            ->with(['mascota', 'servicio', 'pago'])
            ->whereIn('estado', ['completada', 'cancelada', 'no_asistio'])
            ->orderByDesc('fecha_hora_inicio')
            ->get()
            ->map(fn($c) => [
                $c->mascota->nombre ?? '—',
                $c->servicio->nombre ?? '—',
                $c->fecha_hora_inicio?->format('d/m/Y H:i'),
                ucfirst($c->estado),
                $c->estado === 'completada' ? number_format($c->pago?->total ?? $c->precio_acordado, 2) : '—',
            ]);
    }
}

class ClientePuntosSheet implements FromCollection, WithHeadings, WithTitle
{
    public function __construct(public int $userId) {}
    public function title(): string { return 'Puntos'; }
    public function headings(): array { return ['Concepto', 'Puntos', 'Fecha']; }

    public function collection()
    {
        return PuntoCliente::where('cliente_id', $this->userId)
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($p) => [
                $p->concepto,
                $p->puntos,
                $p->created_at->format('d/m/Y'),
            ]);
    }
}
