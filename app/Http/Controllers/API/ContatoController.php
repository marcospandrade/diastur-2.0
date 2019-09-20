<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contato;
use Mail;

class ContatoController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'nome_contato' => 'required',
            'email_contato' => 'required|email',
            'telefone_contato' => 'required',
            'mensagem_contato' => 'required'
            ]);
            $to_name = 'Indicatur Bot';
            $to_email = 'indicatur2@gmail.com';
            $from_name = $request->nome_contato;
            $subject = $from_name . " enviou um formulário de Contato";
            $data = array(
                'nome_contato' => $from_name,
                'email_contato' => $request->email_contato,
                'telefone_contato' => $request->telefone_contato,
                'mensagem_contato' => $request->mensagem_contato
            );
            Mail::send('mail.contatoemail', $data, function($message) use ($to_name, $to_email,$subject) {
                $message->to($to_email, $to_name)
                        ->subject($subject)
                        ->from('indicatur2@gmail.com', 'Bot');
            });
            
        return Contato::create([
            'nome_contato' => $request['nome_contato'],
            'email_contato' => $request['email_contato'],
            'telefone_contato' => $request['telefone_contato'],
            'mensagem_contato' => $request['mensagem_contato']
        ]);
    }

    public function lista(){
    	return view('lista', array('contatos' => Contato::all()));
    }
}
