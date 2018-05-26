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
            $table->string('equipo_1');
            $table->string('equipo_2');
            $table->unsignedInteger('equipo_id');
            $table->foreign('equipo_id')->references('id')->on('equipos');
            $table->enum('estado', ['Activo', 'Incativo']);
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
