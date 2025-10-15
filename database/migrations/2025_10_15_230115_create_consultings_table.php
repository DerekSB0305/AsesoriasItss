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
        Schema::create('consultings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_user')->constrained('teachers')->onDelete('cascade'); # ID del profesor
            $table->foreignId('enrollment')->constrained('students')->onDelete('cascade'); # Matreícula del alumno
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade'); # ID de la materia
            $table->dateTime('consulting_date'); # Fecha y hora de la asesoría
            $table->string('classroom', 10); # Aula
            $table->string('building', 10); # Edificio
            $table->string('assignment_sheet')->nullable(); # Hoja de asignación
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultings');
    }
};
