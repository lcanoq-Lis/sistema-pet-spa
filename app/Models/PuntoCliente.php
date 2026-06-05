<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoCliente extends Model
{
    protected $fillable = ['cliente_id', 'puntos', 'concepto', 'cita_id'];
    protected $table = 'puntos_cliente';

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}