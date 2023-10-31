<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Boleto
 *
 * @property $idBoleto
 * @property $FechaBoleto
 * @property $Cantidad
 * @property $id_viaje
 * @property $id_user
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Viaje $viaje
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Boleto extends Model
{
    protected $table = "boleto";
    protected $primaryKey = 'idBoleto';
    static $rules = [
		'idBoleto' => 'required',
		'Cantidad' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['idBoleto','FechaBoleto','Cantidad','id_viaje','id_user'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'id_user');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function viaje()
    {
        return $this->hasOne('App\Models\Viaje', 'idViaje', 'id_viaje');
    }
    

}
