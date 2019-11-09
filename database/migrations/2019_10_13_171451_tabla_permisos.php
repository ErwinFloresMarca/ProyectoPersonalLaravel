<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablaPermisos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos',function(Blueprint $table){
            $table->increments('id');
            $table->integer('archivo_id')->unsigned();
            $table->foreign('archivo_id')->references('id')->on('archivos');
            $table->boolean('editar');
            $table->boolean('ver');
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
        Schema::dropIfExists('permisos');
    }
}
