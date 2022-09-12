<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
    protected $table = 'turno';
    
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    
    public function vehiculo(){
        return $this->belongsTo('App\Models\Vehiculo', 'vehiculo_id');
    }
    
    public function servicio(){
        return $this->belongsTo('App\Models\Servicios', 'servicio_id');
    }
}
