<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solicitacao extends Model
{
    protected $primaryKey = 'id_solicitacao';
    const CREATED_AT = 'data_solicitacao';
    protected $table = 'solicitacoes';
    
    protected $fillable = [
        'usuario_solicitante',
        'data_solicitacao' ,
        'quantidade_pontos', 
        'destino_desconto'
    ];
    public function solicitadoPor(){
        return $this->belongsTo('App\Usuario', 'usuario_solicitante');
    }
}
