<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Indicado;
use DB;
use App\Usuario;

class IndicadoController extends Controller
{
    public function index(){
        return Indicado::latest()->paginate(5);
    }
    
    public function exibirPeloIdIndicador($id){
        
        $indicados = DB::select('select * from indicados where usuario_indicador = ?', [$id]);
        return response()->json($indicados);
    }

    public function update(Request $request, $id)
    {
        $indicado = Indicado::findOrFail($id);
        $indicado->update($request->all());
        return ['message' => 'Informações do indicado atualizadas'];
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'nome_indicado' => 'required|string|max:191',
            'cpf_indicado' => 'required|string|max:30|unique:indicados',
            'telefone_indicado' => 'required|max:20',
            'email_indicado' => 'required|string|email|max:191|unique:indicados',
        ]);
        $indicado = Indicado::create([
            'nome_indicado' => $request['nome_indicado'],
            'cpf_indicado' => $request['cpf_indicado'],
            'email_indicado' => $request['email_indicado'],
            'telefone_indicado' =>$request['telefone_indicado'],
            'usuario_indicador' => $request['usuario_indicador']
        ]);
        return response()->json($indicado);
    }
    public function show(){
        if ($search = \Request::get('q')) {
            $indicados = Indicado::where(function($query) use ($search){
                $query->where('nome_indicado','LIKE',"%$search%");
            })->paginate(5);
        }else{
            $indicados = Indicado::latest()->paginate(5);
        }
        return $indicados;
    }
}
