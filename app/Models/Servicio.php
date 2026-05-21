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

    public function duracionParaTamano($tamano, $temperamento = null)
    {
        $factores = $this->factor_tamano_raza ?? [];
        $factor   = $factores[$tamano] ?? 1.0;
        $duracion = (int) ceil($this->duracion_base_minutos * $factor);

        // Ajuste por temperamento nervioso o agresivo
        if (in_array($temperamento, ['agresivo', 'nervioso'])) {
            $duracion = (int) ceil($duracion * 1.20);
        }

        return $duracion;
    }
    }
