<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvolucionMascota extends Model
{
    protected $table = 'evolucion_mascota';

    protected $fillable = ['mascota_id', 'titulo', 'descripcion', 'foto_antes', 'foto_despues', 'fecha'];

    protected $casts = ['fecha' => 'date'];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }
}