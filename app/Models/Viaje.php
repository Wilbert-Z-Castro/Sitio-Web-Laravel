<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Viaje
 *
 * @property $idViaje
 * @property $FechaViaje
 * @property $Descripcion
 * @property $Origen
 * @property $Destino
 * @property $Disponibles
 * @property $id_autobus
 * @property $created_at
 * @property $updated_at
 *
 * @property Autobu $autobu
 * @property Boleto[] $boletos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Viaje extends Model
{
    protected $table = "viaje";
    protected $primaryKey = 'idViaje';
    static $rules = [
		'idViaje' => 'required',
		'FechaViaje' => 'required',
		'Descripcion' => 'required',
		'Origen' => 'required',
		'Destino' => 'required',
        'id_autobus' => 'required',
		
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idViaje','FechaViaje','Descripcion','Origen','Destino','id_autobus'];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function autobu()
    {
        return $this->hasOne('App\Models\Autobu', 'idAutobus', 'id_autobus');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function boletos()
    {
        return $this->hasMany('App\Models\Boleto', 'id_viaje', 'idViaje');
    }
    

}
