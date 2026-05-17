<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $table = 'notificaciones';

    protected $fillable = [
        'cliente_id', 'cita_id', 'tipo_evento', 'canal',
        'destino', 'contenido', 'fecha_programacion',
        'fecha_envio', 'estado', 'intentos'
    ];

    protected $casts = [
        'fecha_programacion' => 'datetime',
        'fecha_envio'        => 'datetime',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}