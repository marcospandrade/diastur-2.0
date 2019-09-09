<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Solicitacoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('usuario_solicitante')->unsigned();
            $table->foreign('usuario_solicitante')
                  ->references('id')->on('usuarios');
            $table->integer('quantidade_pontos');
            $table->string('destino_desconto'); 
            $table->DateTime('data_solicitacao');
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
