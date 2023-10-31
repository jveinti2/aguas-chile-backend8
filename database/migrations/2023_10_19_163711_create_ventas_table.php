<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->integer('cliente_id')->nullable();
            $table->integer('edificio_id')->nullable();
            $table->integer('producto_id')->nullable();
            $table->integer('cantidad_bidones')->nullable();
            $table->integer('modulo')->nullable();
            $table->boolean('domicilio')->nullable();
            $table->integer('domiciliario_id')->nullable();
            $table->string('direccion_domicilio')->nullable();
            $table->integer('estado_domicilio')->nullable();
            $table->integer('forma_pago_id')->nullable();
            $table->string('pdf')->nullable();
            $table->dateTime('fh_creacion');
            $table->dateTime('fh_modificacion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
