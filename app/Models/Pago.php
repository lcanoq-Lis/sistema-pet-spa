<?php
// app/Models/Pago.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'cita_id', 'metodo', 'monto', 'descuento',
        'total', 'referencia', 'observaciones',
        'estado', 'registrado_por',
    ];

    protected $casts = [
        'monto'     => 'decimal:2',
        'descuento' => 'decimal:2',
        'total'     => 'decimal:2',
    ];

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function registradoPor()
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    public function getMetodoIconoAttribute(): string
    {
        return match($this->metodo) {
            'efectivo'      => '💵',
            'qr'            => '📱',
            'transferencia' => '🏦',
            default         => '💰',
        };
    }

    public function getMetodoLabelAttribute(): string
    {
        return match($this->metodo) {
            'efectivo'      => 'Efectivo',
            'qr'            => 'QR / Billetera digital',
            'transferencia' => 'Transferencia bancaria',
            default         => $this->metodo,
        };
    }
}
