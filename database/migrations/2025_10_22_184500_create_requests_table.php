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
        Schema::create('requests', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('enrollment', 8);
            $table->string('teacher_user', 50);
            $table->unsignedBigInteger('subject_id');
            $table->string('canalization_file', 45)->nullable();

            $table->foreign('enrollment')->references('enrollment')->on('students')->onDelete('cascade');
            $table->foreign('teacher_user')->references('teacher_user')->on('teachers')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
