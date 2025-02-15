<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('intento_fraudes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');  // ID del usuario sospechoso
            $table->text('motivo');                    // Motivo del intento de fraude
            $table->string('direccion_ip', 45)->nullable();  // Dirección IP
            $table->text('agente_usuario')->nullable();      // Información del navegador/dispositivo
            $table->timestamp('detectado_en')->default(now()); // Fecha y hora de detección
            $table->enum('estado', ['pendiente', 'revisado', 'confirmado', 'falso_positivo'])->default('pendiente');
            
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intento_fraudes');
    }
};
