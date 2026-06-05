<?php

namespace App\Exports;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\PuntoCliente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

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

    public function headings(): array
    {
        return ['Mascota', 'Servicio', 'Fecha', 'Estado', 'Total (Bs.)'];
    }

    public function collection()
    {
        $cliente = Cliente::where('usuario_id', $this->userId)->first();
         if (!$cliente) return collect();
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

    public function headings(): array
    {
        return ['Concepto', 'Puntos', 'Fecha'];
    }

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
