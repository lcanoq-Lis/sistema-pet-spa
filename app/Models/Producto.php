<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'categoria_id', 'sku', 'nombre', 'descripcion',
        'precio_base', 'stock', 'stock_minimo', 'imagen_url', 'activo'
    ];

    protected $casts = [
        'activo'      => 'boolean',
        'precio_base' => 'decimal:2',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_id');
    }

    public function variantes()
    {
        return $this->hasMany(VarianteProducto::class, 'producto_id');
    }

    public function bajoPorStock()
    {
        return $this->stock <= $this->stock_minimo;
    }
}