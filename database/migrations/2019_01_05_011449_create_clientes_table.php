<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('st_nome');
            $table->string('st_cpf');
            $table->string('st_rg');
            $table->date('dt_nascimento');
            $table->string('st_endereco');
            $table->string('st_municipio');
            $table->string('st_estado');
            $table->string('st_celeular');
            $table->string('st_tel_fixo');
            $table->string('st_email');
        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
