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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50); # Nombre(s)
            $table->string('last_name_father', 50); # Apellido paterno
            $table->string('last_name_mother', 50); # Apellido materno
            $table->foreignId('career_id')->constrained('careers')->onDelete('cascade'); # ID de la carrera
            $table->string('study_degree', 50); # Grado de estudio
            $table->boolean('tutor')->default(false); # Indica si es tutorG
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
