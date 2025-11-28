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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id('subject_id');
            $table->string('name', 50); # Nombre de la materia
            $table->string('type', 50)->nullable(); # Tipo de materia (obligatoria, optativa, etc.)
            $table->unsignedBigInteger('career_id')->nullable(); # Carrera a la que pertenece
            $table->string('period', 50)->nullable();

            $table->foreign('career_id')->references('career_id')->on('careers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
