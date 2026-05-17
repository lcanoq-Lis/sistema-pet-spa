<?php

namespace App\Helpers;

use App\Models\AuthLog;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function registrar(string $evento, string $descripcion = null)
    {
        $usuario = Auth::user();

        AuthLog::create([
            'usuario_id'  => $usuario?->id,
            'rol'         => $usuario?->rol?->nombre,
            'evento'      => $evento,
            'descripcion' => $descripcion,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
