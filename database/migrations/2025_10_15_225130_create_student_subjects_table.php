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
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment')->constrained('students')->onDelete('cascade'); # Matreícula del alumno
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); # ID de la materia
            $table->timestamps();

            #Evitar duplicados
            $table->unique(['enrollment', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subjects');
    }
};
