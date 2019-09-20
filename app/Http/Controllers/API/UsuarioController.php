<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use Illuminate\Support\Facades\Hash;
use Auth;

class UsuarioController extends Controller
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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isAuthor')) {
            return Usuario::latest()->paginate(5);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:usuarios',
            'password' => 'required|string|min:6'
        ]);
        return Usuario::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'telefone' =>$request['telefone'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
        ]);
    }
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:usuarios,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPhoto = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }
        }
        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }
        $user->update($request->all());
        return ['message' => "Success"];
    }
    public function profile()
    {
        return auth('api')->user();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Usuario::findOrFail($id);
        return response()->json($user);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Usuario::findOrFail($id);
        $this->validate($request,[
            'nome_usuario' => 'required|string|max:191',
            'cpf_usuario' => 'required',
            'email_usuario' => 'required|string|email|max:191|unique:usuarios,email,'.$user->id,
            'password' => 'sometimes|min:6'
        ]);
        $user ->update($request->all());
        return ['message' => 'Updated user info'];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = Usuario::findOrFail($id);
        // delete the user
        $user->delete();
        return ['message' => 'Usuário deletado.'];
    }
    public function search(){
        if ($search = \Request::get('q')) {
            $users = Usuario::where(function($query) use ($search){
                $query->where('nome_usuario','LIKE',"%$search%")
                        ->orWhere('email_usuario','LIKE',"%$search%")
                        ->orWhere('tipo_usuario','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $users = Usuario::latest()->paginate(5);
        }
        return $users;
    }
    public function getMyID(){
        return auth('api')->user()->id;       
    }
}
