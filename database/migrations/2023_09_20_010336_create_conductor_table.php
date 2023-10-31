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
        Schema::create('conductor', function (Blueprint $table) {
            
            $table->engine="InnoDB";
            $table->id('idConductor');
            $table->string('NomConductor');
            $table->string('ApeConductor');
            $table->date('Fechaingreso')->nullable();
            $table->date('FechaNa');
            $table->enum('Genero', ['Hombre', 'Mujer','Otro']);
            $table->String('Telefono');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conductor');
    }
};
