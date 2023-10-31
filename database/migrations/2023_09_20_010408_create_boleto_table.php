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
        Schema::create('boleto', function (Blueprint $table) {
            $table->id('idBoleto');
            $table->date('FechaBoleto')->nullable();
            $table->integer('Cantidad');
            //relacion con la tabla viaje
            $table->unsignedBigInteger('id_viaje')->nullable();
            //relacion con la tabla usuario
            $table->unsignedBigInteger('id_user')->nullable();
            //creacion de la relacion con la tabla viaje 
            $table->foreign('id_viaje')->references('idViaje')->on('viaje')->onDelete('set null');
            //creacion de la relacion con la tabla usuario 
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boleto');
    }
};
