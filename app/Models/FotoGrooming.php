<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoGrooming extends Model
{
    protected $table = 'fotos_grooming';

    const CREATED_AT = 'creado_en';
    const UPDATED_AT = null;

    protected $fillable = [
        'ficha_id', 'tipo', 'url'
    ];
}