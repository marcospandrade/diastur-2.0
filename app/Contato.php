<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $primaryKey = 'id_contato';
    public $table = 'contatos';
    
    
    public $fillable = [
        'nome_contato', 
        'email_contato', 
        'telefone_contato', 
        'mensagem_contato'
    ];
}
