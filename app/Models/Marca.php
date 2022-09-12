<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marca';
    
    public function tipo_vehiculo(){
        return $this->belongsTo('App\Models\TipoDeVehiculo','tipo_vehiculo_id');
    }
}
