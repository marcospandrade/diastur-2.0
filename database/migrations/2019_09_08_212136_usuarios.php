<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome_usuario');
            $table->string('cpf_usuario')->unique();
            $table->string('email_usuario')->unique();
            $table->string('telefone_usuario');
            $table->string('password_usuario');
            $table->string('tipo_usuario')->default('cliente');  
            $table->string('foto_usuario')->default('usuariofoto.png');
            $table->integer('pontuacao_usuario')->default(0);
            $table->unsignedInteger('indicados')->unsigned()->nullable();
            $table->unsignedInteger('solicitacoes')->unsigned()->nullable();
            $table->unsignedInteger('transferencias')->unsigned()->nullable();
            $table->rememberToken();
            $table->DateTime('last_update');
            $table->Date('creation_date'); 
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
