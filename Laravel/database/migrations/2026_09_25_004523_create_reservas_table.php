<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations. (Crea la tabla en MySQL)
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('personas');
            $table->string('telefono')->nullable();
            $table->dateTime('fecha_reserva')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations. (Borra la tabla si revertimos)
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
