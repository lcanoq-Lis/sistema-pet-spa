<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthLog extends Model
{
    protected $fillable = [
        'usuario_id', 'rol', 'evento',
        'ip_address', 'user_agent'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}