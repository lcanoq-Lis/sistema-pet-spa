<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groomer extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'usuario_id', 'nombre', 'apellido',
        'telefono', 'especialidad',
        'capacidad_simultanea', 'activo'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}