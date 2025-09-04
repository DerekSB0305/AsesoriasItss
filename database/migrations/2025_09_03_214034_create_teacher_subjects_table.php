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
        Schema::create('teacher_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); # ID del profesor
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); # ID de la materia
            $table->foreignId('career_id')->constrained('careers')->onDelete('cascade'); # ID de la carrera
            $table->timestamps();

            #Evitar duplicados
            $table->unique(['teacher_id', 'subject_id', 'career_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_subjects');
    }
};
