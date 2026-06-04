<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    protected $fillable = ['user_id', 'cupon_id', 'descuento'];

    protected $casts = [
        'descuento' => 'decimal:2',
    ];

    public function items()
    {
        return $this->hasMany(CarritoItem::class);
    }

    public function cupon()
    {
        return $this->belongsTo(Cupon::class);
    }

    public function subtotal()
    {
        return $this->items->sum(fn($i) => $i->precio_unitario * $i->cantidad);
    }

    public function total()
    {
        return max(0, $this->subtotal() - $this->descuento);
    }

    // Obtener o crear el carrito del usuario actual
    public static function obtenerOCrear($userId)
    {
        return static::firstOrCreate(['user_id' => $userId], ['descuento' => 0]);
    }
}
