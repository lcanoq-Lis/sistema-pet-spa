<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'usuario_id', 'nombre', 'apellido',
        'telefono', 'direccion', 'canal_notificacion'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function mascotas()
    {
        return $this->belongsToMany(Mascota::class, 'mascota_dueno', 'cliente_id', 'mascota_id')
                    ->withPivot('es_primario')
                    ->wherePivot('mascota_id', '!=', null);
    }
}