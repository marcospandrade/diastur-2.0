<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerario extends Model
{
    protected $table = 'itinerarios';
    
    protected $primaryKey = 'id_itinerario';
    
   
    protected $fillable = [
        'origem_itinerario', 
        'destino_itinerario', 
        'banner_itinerario', 
        'itinerario_ativo'
    ];
}
