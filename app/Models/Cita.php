<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'mascota_id', 'groomer_id', 'servicio_id',
        'creado_por_usuario_id', 'estado',
        'fecha_hora_inicio', 'fecha_hora_fin_estimada',
        'precio_acordado', 'notas_cliente', 'motivo_cancelacion'
    ];

    protected $casts = [
        'fecha_hora_inicio'       => 'datetime',
        'fecha_hora_fin_estimada' => 'datetime',
        'precio_acordado'         => 'decimal:2',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function groomer()
    {
        return $this->belongsTo(Groomer::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creado_por_usuario_id');
    }
}