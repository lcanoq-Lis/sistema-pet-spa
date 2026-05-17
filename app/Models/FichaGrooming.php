<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaGrooming extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $table = 'fichas_grooming';

    protected $fillable = [
        'cita_id', 'raza_momento', 'tamano_momento',
        'temperatura_ingreso', 'estado_inicial', 'estado_final',
        'notas_internas', 'consumido_inventario', 'fecha_cierre'
    ];

    protected $casts = [
        'consumido_inventario' => 'boolean',
        'fecha_cierre'         => 'datetime',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function checklist()
    {
        return $this->hasMany(FichaChecklist::class, 'ficha_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoGrooming::class, 'ficha_id');
    }
}