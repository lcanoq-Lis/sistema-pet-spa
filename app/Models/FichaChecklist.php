<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FichaChecklist extends Model
{
    protected $table = 'fichas_checklist';
    public $timestamps = false;

    protected $fillable = [
        'ficha_id', 'item_id', 'completado', 'observacion', 'completado_en'
    ];

    protected $casts = [
        'completado'    => 'boolean',
        'completado_en' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(ChecklistItemCatalogo::class, 'item_id');
    }
}