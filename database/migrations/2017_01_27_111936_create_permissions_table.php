<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('st_nome', 50);
            $table->string('st_label', 200);
            $table->timestamps();
        });
        
        Schema::create('permission_role', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('permission_id')->unsigned();
            $table->integer('rele_id')->unsigned();
            $table->foreign('permission_id')
            ->references('id')
            ->on('permissions')
            ->onDelete('cascade');
            $table->foreign('rele_id')
            ->references('id')
            ->on('roles')
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
        Schema::drop('permission_role');
        Schema::drop('permissions');
    }
}
