<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialty_id',
        'nombres',
        'apellidos',
        'numero_identificacion',
        'registro_profesional',
        'telefono',
        'correo',
        'estado',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "Dr(a). {$this->nombres} {$this->apellidos}";
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopePorEspecialidad($query, int $specialtyId)
    {
        return $query->where('specialty_id', $specialtyId);
    }
}
