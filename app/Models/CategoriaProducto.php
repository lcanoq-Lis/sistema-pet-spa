<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaProducto extends Model
{
    protected $table = 'categorias_productos';

    protected $fillable = ['padre_id', 'nombre', 'descripcion', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function padre()
    {
        return $this->belongsTo(CategoriaProducto::class, 'padre_id');
    }

    public function subcategorias()
    {
        return $this->hasMany(CategoriaProducto::class, 'padre_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}