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
            $table->string('enrollment', 8)->primary();
            $table->string('last_name_f', 50);
            $table->string('last_name_m', 50);
            $table->string('name', 40);
            $table->integer('semester');
            $table->unsignedBigInteger('career_id');
            $table->string('gender', 10);
            $table->integer('age');
            $table->string('teacher_user', 50);

            $table->foreign('career_id')->references('career_id')->on('careers')->onDelete('cascade');
            $table->foreign('teacher_user')->references('teacher_user')->on('teachers')->onDelete('cascade');
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
