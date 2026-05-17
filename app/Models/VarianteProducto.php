<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarianteProducto extends Model
{
    protected $table = 'variantes_producto';

    protected $fillable = [
        'producto_id', 'sku_variante', 'atributo',
        'valor', 'precio_extra', 'stock', 'activo'
    ];

    protected $casts = [
        'activo'      => 'boolean',
        'precio_extra'=> 'decimal:2',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}