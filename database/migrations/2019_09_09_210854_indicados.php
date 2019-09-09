<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class indicados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * 
     * terá os dados do indicador, 
     * do indicado, 
     * cpf do indicado, 
     * telefone do indicado, 
     * email do indicado, 
     * data da indicação e 
     * botões para confirmação ou não da indicação.
     */
    public function up()
    {
        Schema::create('indicados', function (Blueprint $table) {
            $table->increments('id_indicado');
            $table->string('nome_indicado');
            $table->string('cpf_indicado')->unique();
            $table->string('telefone_indicado');
            $table->string('email_indicado')->unique();
            $table->date('data_indicacao');
            $table->unsignedInteger('usuario_indicador')->unsigned();
            $table->foreign('usuario_indicador')
                    ->references('id')
                    ->on('usuarios');
            $table->boolean('validado')->default(false);    
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
        Schema::dropIfExists('indicados');
    }
}