<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservaciones extends Model
{
    protected $table = 'reservas';

    protected $fillable = [
        'fecha_viaje',
        'hora_viaje',
        'origen',
        'destino',
        'id_autobus',
    ];
}