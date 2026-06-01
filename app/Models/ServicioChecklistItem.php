<?php
// app/Models/ServicioChecklistItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioChecklistItem extends Model
{
    public $timestamps = false;
    protected $table   = 'servicio_checklist_items';
    protected $fillable = ['servicio_id', 'item_id', 'orden'];

    public function item()
    {
        return $this->belongsTo(ChecklistItemCatalogo::class, 'item_id');
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}