<?php
// app/Models/HorarioSpa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HorarioSpa extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $table = 'horarios_spa';

    protected $fillable = ['dia_semana', 'hora_apertura', 'hora_cierre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public static $dias = [
        0 => 'Domingo',
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
    ];

    public function getNombreDiaAttribute(): string
    {
        return self::$dias[$this->dia_semana] ?? 'Desconocido';
    }
}
