<?php
// app/Models/Promocion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promociones';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre', 'descripcion', 'tipo', 'valor',
        'servicio_id', 'min_citas', 'fecha_inicio',
        'fecha_fin', 'activo', 'creado_por',
    ];

    protected $casts = [
        'activo'       => 'boolean',
        'valor'        => 'decimal:2',
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function estaVigente(): bool
    {
        if (!$this->activo) return false;
        $hoy = now()->toDateString();
        if ($this->fecha_inicio && $hoy < $this->fecha_inicio->toDateString()) return false;
        if ($this->fecha_fin   && $hoy > $this->fecha_fin->toDateString())   return false;
        return true;
    }

    public function calcularDescuento(float $monto): float
    {
        return match($this->tipo) {
            'porcentaje'        => round($monto * ($this->valor / 100), 2),
            'monto_fijo'        => min($this->valor, $monto),
            'cliente_frecuente' => round($monto * ($this->valor / 100), 2),
            default             => 0,
        };
    }

    public function getTipoLabelAttribute(): string
    {
        return match($this->tipo) {
            'porcentaje'        => "{$this->valor}% de descuento",
            'monto_fijo'        => "Bs. {$this->valor} de descuento fijo",
            'cliente_frecuente' => "{$this->valor}% cliente frecuente (+{$this->min_citas} citas)",
            default             => $this->tipo,
        };
    }
}
