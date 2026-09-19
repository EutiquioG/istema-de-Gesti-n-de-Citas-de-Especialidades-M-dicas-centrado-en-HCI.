<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'fecha_nacimiento', 'telefono', 'correo', 'direccion', 'estado',];

    protected function casts(): array
    {
        return ['fecha_nacimiento' => 'date',];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }
}
