<?php
namespace App;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Usuario extends Authenticatable
{
    use Notifiable, HasApiTokens;
    
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $fillable = [
        'nome_usuario', 
        'cpf_usuario',
        'email_usuario', 
        'telefone_usuario', 
        'password', 
        'tipo_usuario', 
        'foto_usuario', 
        'pontuacao_usuario',
        'indicados',
        'solicitacoes',
        'transferencias'
    ];
    public function listaIndicados(){
        return $this->hasMany('App\Indicado', 'indicados');
    }
    public function listaSolicitacoes(){
        return $this->hasMany('App\Solicitacao', 'solicitacoes');
    }
    public function listaTransferencias(){
        return $this->hasMany('App\Transferencia', 'transferencias');
    }
    
}