<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    protected $fillable = [
        'codigo', 'nombre', 'tipo', 'valor', 'minimo_compra',
        'uso_maximo', 'usos_actuales', 'fecha_inicio', 'fecha_fin', 'activo'
    ];

    protected $casts = [
        'valor'          => 'decimal:2',
        'minimo_compra'  => 'decimal:2',
        'activo'         => 'boolean',
        'fecha_inicio'   => 'date',
        'fecha_fin'      => 'date',
    ];

    public function esValido()
    {
        $hoy = now()->toDateString();
        return $this->activo
            && $hoy >= $this->fecha_inicio
            && $hoy <= $this->fecha_fin
            && ($this->uso_maximo === null || $this->usos_actuales < $this->uso_maximo);
    }

    public function calcularDescuento($subtotal)
    {
        if ($subtotal < $this->minimo_compra) return 0;

        if ($this->tipo === 'porcentaje') {
            return round($subtotal * ($this->valor / 100), 2);
        }

        return min($this->valor, $subtotal);
    }
}
