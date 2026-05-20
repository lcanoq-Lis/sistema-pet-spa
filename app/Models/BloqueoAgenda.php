<?php
// app/Models/BloqueoAgenda.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueoAgenda extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'creado_en';

    protected $table = 'bloqueos_agenda';

    protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'tipo', 'motivo', 'groomer_id', 'creado_por'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function groomer()
    {
        return $this->belongsTo(Groomer::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    // Verifica si una fecha cae dentro del bloqueo
    public function abarcaFecha(string $fecha): bool
    {
        return $this->fecha_inicio <= $fecha && $fecha <= $this->fecha_fin;
    }
}
