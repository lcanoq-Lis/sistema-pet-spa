<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

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