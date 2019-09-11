<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// get('/user')
Route::middleware('auth:api')->get('/usuario', function (Request $request) {
    return $request->user();
});

//rota de recursos para buscar itinerarios salvos no banco
Route::apiResources(['itinerario' => 'API\ItinerarioController']);
Route::get('buscarItinerario', 'API\ItinerarioController@buscarItinerario');
Route::get('pesquisarOrigem', 'API\ItinerarioController@searchOrigem');
Route::get('pesquisarDestino', 'API\ItinerarioController@searchDestino');
//Route::put('inativarItinerario', 'API\ItinerarioController@inactiveItinerario');

//Indicado
Route::apiResources(['indicado' => 'API\IndicadoController']);
Route::get('exibirPeloIdIndicador', 'API\IndicadoController@exibirPeloIdIndicador');

//transferencia
Route::apiResources(['transferencia' => 'API\TransferenciaController']);
Route::get('usuariosCadastrados', 'API\TransferenciaController@usersCadastrados');
Route::post('registrarTransferencia', 'API\TransferenciaController@registrarTransferencia');

//Usuario
Route::apiResources(['user' => 'API\UserController']);
Route::get('perfil', 'API\UserController@profile');
Route::put('atualizarPerfil', 'API\UserController@updateProfile');
Route::get('buscarMeuId', 'API\UserController@getMyID');
Route::get('buscarUsuario', 'API\UserController@search');

//Contato
Route::post('formularioContato', 'ContatoController@store');
