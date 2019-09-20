<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use DB;
use App\Indicado;

class TransferenciaController extends Controller
{
    public function usersCadastrados(){
        return Usuario::all();
    }
    public function show($id){
        $indicados = DB::select('select * from indicados where user_indicador = ?', [$id]);
        /*if($id){
            $indicado = User::find($id)->where('temIndicados');        
        }else{
            return['message' => 'Deu ruim pra buscar indicados pelo ID do indicador', 'indicado' => $id];
        }*/
        return response()->json($indicados);
    }
    
    public function registrarTransferencia(Request $request){
        //    
    }
}
