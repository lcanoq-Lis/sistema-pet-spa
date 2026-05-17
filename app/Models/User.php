<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'rol_id', 'ci',
        'proveedor_oauth', 'oauth_id', 'email_verificado',
        'token_verificacion', 'token_expira_en',
        'intentos_fallidos', 'bloqueado_hasta',
        'two_factor_secret', 'two_factor_enabled',
        'ultimo_acceso', 'activo'
    ];

    protected $hidden = [
        'password', 'remember_token',
        'two_factor_secret', 'token_verificacion'
    ];

    protected $casts = [
        'email_verified_at'   => 'datetime',
        'token_expira_en'     => 'datetime',
        'bloqueado_hasta'     => 'datetime',
        'ultimo_acceso'       => 'datetime',
        'email_verificado'    => 'boolean',
        'two_factor_enabled'  => 'boolean',
        'activo'              => 'boolean',
        'password'            => 'hashed',
    ];

    public function rol()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'user_id');
    }

    public function groomer()
    {
        return $this->hasOne(Groomer::class, 'user_id');
    }

    public function authLogs()
    {
        return $this->hasMany(AuthLog::class, 'usuario_id');
    }

    public function estaActivo(): bool
    {
        return $this->activo;
    }

    public function estaBloqueado(): bool
    {
        return $this->bloqueado_hasta && $this->bloqueado_hasta->isFuture();
    }
}