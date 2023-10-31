<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Conductor
 *
 * @property $idConductor
 * @property $NomConductor
 * @property $ApeConductor
 * @property $Fechaingreso
 * @property $FechaNa
 * @property $Genero
 * @property $Telefono
 * @property $created_at
 * @property $updated_at
 *
 * @property Autobu[] $autobuses
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Conductor extends Model
{
  protected $primaryKey = 'idConductor';
    


    static $rules = [
      'idConductor' => 'required|numeric',
		'NomConductor' => 'required',
		'ApeConductor' => 'required',
		'FechaNa' => 'required|date',
		'Genero' => 'required',
		'Telefono' => 'required',
    ];

    

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idConductor','NomConductor','ApeConductor','FechaNa','Genero','Telefono'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autobuses()
    {
        return $this->hasMany('App\Models\Autobu', 'id_Conductor', 'idConductor');
    }
    

}
