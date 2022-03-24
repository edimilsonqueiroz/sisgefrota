<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManutencaoMaquinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manutencao_maquinas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('maquina_id');
            $table->integer('user_aprovacao');
            $table->integer('user_devolucao');
            $table->string('justificativa_devolucao');
            $table->string('descricao_manutencao');
            $table->integer('tipo_manutencao');
            $table->string('justificativa');
            $table->integer('status');
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
        Schema::dropIfExists('manutencao_maquinas');
    }
}
