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
        Schema::create('paquete_transaccion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_paquetes_id')->constrained()->onDelete('cascade');
            $table->text('amount'); 
            $table->text('razon'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_transaccion');
    }
};
