<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VacunaMascota extends Model
{
    protected $table = 'vacunas_mascota';
    public $timestamps = false;

    protected $fillable = [
        'mascota_id', 'nombre_vacuna', 'fecha_aplicacion',
        'fecha_vencimiento', 'observaciones'
    ];

    protected $casts = [
        'fecha_aplicacion'  => 'date',
        'fecha_vencimiento' => 'date',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function estaVigente()
    {
        return !$this->fecha_vencimiento || $this->fecha_vencimiento->isFuture();
    }
}