<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reserva extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'nombre',
        'personas',
        'telefono',
        'fecha_reserva',
        'estado',
        'mesa',
        'notas',
    ];

    protected $casts = [
        'personas' => 'integer',
        'fecha_reserva' => 'datetime',
    ];
}
