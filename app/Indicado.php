<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicado extends Model
{
    protected $primaryKey = 'id_indicado';
    const CREATED_AT = 'data_indicacao';
    
    protected $fillable = [
        'nome_indicado', 
        'cpf_indicado',
        'telefone_indicado',
        'email_indicado', 
        'data_indicacao',
        'validado',
        'usuario_indicador'
    ];
    public function indicadoPor(){
        return $this->belongsTo('App\Usuario', 'usuario_indicador');
    }
}
