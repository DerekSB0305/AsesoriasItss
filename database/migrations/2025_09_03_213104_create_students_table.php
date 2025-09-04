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
        Schema::create('students', function (Blueprint $table) {
            $table->string('enrollment', 8)->primary(); // Matrícula
            $table->string('last_name_father', 50); // Apellido paterno
            $table->string('last_name_mother', 50); // Apellido materno    
            $table->string('first_name', 50); // Nombre(s)
            $table->integer('semester'); // Semestre
            $table->foreignId('career_id')->constrained('careers')->onDelete('cascade'); // ID de la carrera
            $table->string('gender', 10); // Género
            $table->integer('age'); // Edad
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); // ID del tutor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
