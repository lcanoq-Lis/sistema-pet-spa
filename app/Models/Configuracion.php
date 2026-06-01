<?php
// app/Models/Configuracion.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table      = 'configuracion';
    protected $primaryKey = 'clave';
    public $incrementing  = false;
    protected $keyType    = 'string';
    public $timestamps    = false;
    const UPDATED_AT      = 'actualizado_en';

    protected $fillable = ['clave', 'valor', 'descripcion'];

    // Helper estático para obtener un valor
    public static function obtener(string $clave, $default = null)
    {
        $config = static::find($clave);
        return $config ? $config->valor : $default;
    }

    // Helper estático para guardar un valor
    public static function guardar(string $clave, string $valor): void
    {
        static::updateOrCreate(['clave' => $clave], ['valor' => $valor]);
    }
}