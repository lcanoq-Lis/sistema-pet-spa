<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistItemCatalogo extends Model
{
    protected $table = 'checklist_items_catalogo';

    protected $fillable = [
        'servicio_id', 'nombre', 'descripcion',
        'requiere_observacion', 'orden', 'activo'
    ];

    protected $casts = [
        'requiere_observacion' => 'boolean',
        'activo'               => 'boolean',
    ];
}