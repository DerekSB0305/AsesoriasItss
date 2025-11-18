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
        Schema::create('manuals', function (Blueprint $table) {
            $table->id();
              // Relación con teacher_subjects
            $table->unsignedBigInteger('teacher_subject_id');

            // Datos del manual
            $table->string('title', 150);
            $table->string('file_path');

            $table->timestamps();

            // Foreign key con unsignedBigInteger
            $table->foreign('teacher_subject_id')
                ->references('id')
                ->on('teacher_subjects')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manuals');
    }
};
