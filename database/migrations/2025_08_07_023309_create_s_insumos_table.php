<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('s_insumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('solicitud_id')->constrained('solicitudes')->onDelete('cascade');
            $table->string('tipo'); // Ej: HDMI, CRED, VGA, etc.
            $table->string('numero_asignado')->nullable(); // Ej: HDMI_1, CRED_2, etc.
            $table->enum('estatus', ['en tiempo', 'con deuda', 'devuelto'])->default('en tiempo');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('s_insumos');
    }
};
