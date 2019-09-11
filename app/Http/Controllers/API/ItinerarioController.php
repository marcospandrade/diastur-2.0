<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Itinerario;
use DB;

class ItinerarioController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Itinerario::latest()->paginate(5);
        }
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'origem_itinerario' => 'required|string|max:191',
            'destino_itinerario' => 'required|string|max:191',
        ]);
        
        $nameBanner = 'usuario.png';
        if($request->banner_itinerario){
            $nameBanner = time().'.' . explode('/', explode(':', substr($request->banner_itinerario, 0, strpos($request->banner_itinerario, ';')))[1])[1];
            \Image::make($request->banner_itinerario)->save(public_path('img/itinerarios/').$nameBanner);
        }
        
        return Itinerario::create([
            'origem_itinerario' => $request['origem_itinerario'],
            'destino_itinerario' => $request['destino_itinerario'],
            'banner_itinerario' => $nameBanner,
            'itinerario_ativo' => $request['itinerario_ativo']
        ]);
    }
    public function update(Request $request, $id)
    {
        $itinerario = Itinerario::findOrFail($id);
        $this->validate($request,[
            'origem_itinerario' => 'required|string|max:191',
            'destino_itinerario' => 'required|string|max:191'           
        ]);
        $currentPhotoBanner = $itinerario->banner_itinerario;
        if($currentPhotoBanner != $request->banner_itinerario){
            $nameBanner = time().'.' . explode('/', explode(':', substr($request->banner_itinerario, 0, strpos($request->banner_itinerario, ';')))[1])[1];
            \Image::make($request->banner_itinerario)->save(public_path('img/itinerarios/').$nameBanner);
            $request->merge(['banner_itinerario' => $nameBanner]);
            $bannerPhoto = public_path('img/profile/').$currentPhotoBanner;
            if(file_exists($bannerPhoto)){
                @unlink($bannerPhoto);
            }
            
        }        
        $itinerario->update($request->all());
        return ['message' => 'Atualizadas as informacoes do Itinerario'];
    }
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $itinerario = Itinerario::findOrFail($id);
        // delete the itinerario
        $itinerario->delete();
        return ['message' => 'Itinerário deletado.'];
    }
    public function buscarItinerario(){
        if ($search = \Request::get('q')) {
            $itinerario = Itinerario::where(function($query) use ($search){
                $query->where('origem_itinerario','LIKE',"%$search%")
                        ->orWhere('destino_itinerario','LIKE',"%$search%");                        
            })->paginate(10);
        }else{
            $itinerario = Itinerario::latest()->paginate(5);
        }
        return $itinerario;
    }
    
    public function pesquisarOrigem(){
        $queryString = Input::get('queryString');
        $itinerarios = Itinerario::where('origem_itinerario', 'LIKE', '%'. $queryString .'%')->get();
        return response()->json($itinerarios);
    }
    public function pesquisarDestino(){
        $queryString = Input::get('queryString');
        $itinerarios = Itinerario::where('destino_itinerario', 'LIKE', '%'.$queryString.'%')->get();
        return response()->json($itinerarios);
    }

    public function fetch (Request $request){
        if($request->get('query')){
            $query = $request->get('query');
            $data = DB::table('itinerarios')
                    ->where('origem_itinerario', 'LIKE', '%{query}%')
                    ->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            foreach($data as $row){
                $output .= '<li><a href="#">'.$row->origem_itinerario.'</a></li>';
            }
            $output .= '</ul>';
            echo $output;
            
        }
    }
    /* Inativar itinerario
    public function inactiveItinerario(Request $request, $id){
        $itinerario = Itinerario::findOrFail($id);
        $itinerario->merge(['itinerario_ativo' => 0]);
        $itinerario->update($request->itinerario_ativo);
        return ['message' => 'Itinerario inativado'];
    }*/
}
