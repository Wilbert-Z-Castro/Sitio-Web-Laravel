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
        Schema::create('viaje', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id('idViaje');
            $table->dateTime('FechaViaje');
            $table->string('Descripcion');
            $table->string('Origen');
            $table->string('Destino');
            $table->integer('Disponibles');
            $table->unsignedBigInteger('id_autobus')->nullable();
            //creacion de la relacion con la tabla autobus 
            $table->foreign('id_autobus')->references('idAutobus')->on('autobus')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viaje');
    }
};
