<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pollas', function (Blueprint $table) {
            $table->increments('id');
//            $table->unsignedInteger('cliente_id');
//            $table->foreign('cliente_id')->references('id')->on('users');
            $table->unsignedInteger('equipo_1');
            $table->foreign('equipo_1')->references('id')->on('equipos');
            $table->unsignedInteger('equipo_2');
            $table->foreign('equipo_2')->references('id')->on('equipos');
            $table->enum('estado', ['Activo', 'Inactivo']);
            $table->dateTime('fecha_partido');
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
        Schema::dropIfExists('pollas');
    }
}
