<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transferencia extends Model
{
    protected $primaryKey = 'id_transferencia';
    protected $table = 'transferencias';
    const CREATED_AT = 'data_transferencia';

    protected $fillable = [
        'quantidade_pontos',
        'usuario_transferidor', 
        'usuario_recebedor',
        'data_transferencia'
    ];
    public function usuarioQueTransfere(){
        return $this->belongsTo('App\Usuario', 'usuario_transferidor');
    }
    public function usuarioQueRecebe(){
        return $this->belongsTo('App\Usuario', 'usuario_recebedor');
    }
}
