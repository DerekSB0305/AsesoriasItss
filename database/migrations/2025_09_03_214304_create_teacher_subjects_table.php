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
            $table->id('teacher_subject_id');
            $table->string('teacher_user', 50);
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('career_id');

            $table->foreign('teacher_user')->references('teacher_user')->on('teachers')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->foreign('career_id')->references('career_id')->on('careers')->onDelete('cascade');
            $table->timestamps();

            #Evitar duplicados
            $table->unique(['teacher_user', 'subject_id', 'career_id']);
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
