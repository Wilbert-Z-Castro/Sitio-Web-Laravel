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
        Schema::create('autobus', function (Blueprint $table) {
            $table->engine="InnoDB";
            $table->id('idAutobus');
            //foranea de conductor 
            $table->unsignedBigInteger('id_Conductor')->nullable();
            $table->string('Matricula');
            $table->string('Modelo');
            $table->string('Color')->nullable();
            $table->integer('Capacidad');
            //creacion de la relacion con la tabla conductor 
            $table->foreign('id_Conductor')->references('idConductor')->on('conductor')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('autobus');
    }
};
