<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Itinerarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itinerarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('origem_itinerario');
            $table->string('destino_itinerario');
            $table->string('banner_itinerario');
            $table->boolean('itinerario_ativo')->default(true);
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itinerarios');
    }
}