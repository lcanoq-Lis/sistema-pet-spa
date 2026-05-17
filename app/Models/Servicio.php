<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre', 'descripcion', 'precio_base',
        'duracion_base_minutos', 'factor_tamano_raza',
        'permite_doble_booking', 'activo'
    ];

    protected $casts = [
        'factor_tamano_raza' => 'array',
        'permite_doble_booking' => 'boolean',
        'activo' => 'boolean',
        'precio_base' => 'decimal:2',
    ];

    public function duracionParaTamano($tamano)
    {
        $factores = $this->factor_tamano_raza ?? [];
        $factor = $factores[$tamano] ?? 1.0;
        return (int) ceil($this->duracion_base_minutos * $factor);
    }
}
