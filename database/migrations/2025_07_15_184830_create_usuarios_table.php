<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('usuarios', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // nombre completo (lo dividiremos en lógica si es necesario)
        $table->string('app');    // apellido paterno
        $table->string('apm');    // apellido materno
        $table->string('escuela');
        $table->string('contrasena');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
