<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Autobu
 *
 * @property $idAutobus
 * @property $id_Conductor
 * @property $Matricula
 * @property $Modelo
 * @property $Color
 * @property $Capacidad
 * @property $created_at
 * @property $updated_at
 *
 * @property Conductor $conductor
 * @property Viaje[] $viajes
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Autobu extends Model
{
    protected $table = "autobus";
    protected $primaryKey = 'idAutobus';
    static $rules = [
		'idAutobus' => 'required',
        'id_Conductor' => 'required',
		'Matricula' => 'required',
		'Modelo' => 'required',
		'Capacidad' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idAutobus','id_Conductor','Matricula','Modelo','Color','Capacidad'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function conductor()
    {
        return $this->hasOne('App\Models\Conductor', 'idConductor', 'id_Conductor');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function viajes()
    {
        return $this->hasMany('App\Models\Viaje', 'id_autobus', 'idAutobus');
    }
    

}
