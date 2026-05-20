<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $fillable = [
        'nombre', 'especie', 'raza', 'tamano',
        'peso_kg', 'fecha_nacimiento', 'temperamento',
        'alergias', 'restricciones_medicas', 'foto_url', 'activo'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo'           => 'boolean',
        'peso_kg'          => 'decimal:2',
    ];

    public function duenos()
    {
        return $this->belongsToMany(Cliente::class, 'mascota_dueno', 'mascota_id', 'cliente_id')
                    ->withPivot('es_primario');
    }

    public function edad()
    {
        if (!$this->fecha_nacimiento) return 'Desconocida';
        
        $anos  = (int) $this->fecha_nacimiento->diffInYears(now());
        $meses = (int) $this->fecha_nacimiento->copy()->addYears($anos)->diffInMonths(now());
        
        if ($anos === 0) {
            return $meses . ' meses';
        } elseif ($meses === 0) {
            return $anos . ' ' . ($anos === 1 ? 'año' : 'años');
        } else {
            return $anos . ' ' . ($anos === 1 ? 'año' : 'años') . ' y ' . $meses . ' meses';
        }
    }
    public function vacunas()
{
    return $this->hasMany(VacunaMascota::class, 'mascota_id');
}
    }