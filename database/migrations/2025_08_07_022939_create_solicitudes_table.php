<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('n_cuenta');
            $table->string('aula');
            $table->string('tel');
            $table->string('unidad_aprendizaje');
            $table->string('profesor');
            $table->string('licenciatura');
            $table->dateTime('fecha_solicitud')->default(now());
            $table->dateTime('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('solicitudes');
    }
}
