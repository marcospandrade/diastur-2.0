<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class Transferencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantidade_pontos');
            $table->unsignedInteger('usuario_transferidor')->unsigned()->nullable();
            $table->foreign('usuario_transferidor')
                  ->references('id')->on('usuarios');
            $table->unsignedInteger('usuario_recebedor')->unsigned()->nullable();
            $table->foreign('usuario_recebedor')
                  ->references('id')->on('usuarios');
            $table->DateTime('data_transferencia');
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
        Schema::dropIfExists('transferencias');
    }
}