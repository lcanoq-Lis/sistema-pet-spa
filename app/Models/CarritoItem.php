<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoItem extends Model
{
    protected $fillable = ['carrito_id', 'producto_id', 'cantidad', 'precio_unitario'];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function subtotal()
    {
        return $this->precio_unitario * $this->cantidad;
    }
}
