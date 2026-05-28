<?php
// app/Models/InsumoGrooming.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsumoGrooming extends Model
{
    public $timestamps = false;
    const CREATED_AT = 'creado_en';

    protected $table = 'insumos_grooming';

    protected $fillable = [
    'ficha_id', 'producto_id', 'cantidad', 'unidad', 'estado', 'observacion'
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
    ];

    public function ficha()
    {
        return $this->belongsTo(FichaGrooming::class, 'ficha_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
