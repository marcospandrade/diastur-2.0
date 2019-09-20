<?php

namespace App\Http\Controllers\Auth;

use App\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected function authenticated(Request $request, $user){
        if($user->isAdminOrAuthor() ){
            return redirect()->route('dashboard');
        }else{
            return redirect()->route('profile');
        }
        
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nome_usuario' => ['required', 'string', 'max:255'],
            'cpf_usuario' => ['required', 'min:11', 'max:14', 'unique:usuarios'],
            'email_usuario' => ['required', 'string', 'email', 'max:255', 'unique:usuarios'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nome_usuario' => $data['nome_usuario'],
            'cpf_usuario' => $data['cpf_usuario'],
            'email_usuario' => $data['email_usuario'],
            'telefone_usuario' => $data['telefone_usuario'],
            'tipo_usuario' => 'user',
            'indicados' => 0,
            'solicitacoes' => 0,
            'transferencias' => 0,
            'password' => Hash::make($data['password']),
        ]);
    }
}
