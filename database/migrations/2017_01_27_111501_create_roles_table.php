<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('st_nome', 50);
            $table->string('st_label', 200);
            
            $table->timestamps();
        });
        
        Schema::create('role_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->integer('usuario_id')->unsigned();
            
            $table->foreign('role_id')
            ->references('id')
            ->on('roles')
            ->onDelete('cascade');
            
            $table->foreign('usuario_id')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::drop('role_user');
         Schema::drop('roles');
       
    }
}
