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
        Schema::create('modulos_edificios', function (Blueprint $table) {
            $table->id();
            $table->integer('modulo_id');
            $table->string('nombre');
            $table->integer('edificio_id');
            $table->integer('capacidad_bidones')->default(1);
            $table->integer('cantidad_bidones')->default(0);
            $table->integer('estado')->default(1);
            $table->string('password')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modulos_edificios');
    }
};
