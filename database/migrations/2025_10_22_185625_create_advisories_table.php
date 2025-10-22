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
        Schema::create('advisories', function (Blueprint $table) {
            $table->id('advisory_id');
            $table->string('teacher_user', 50);
            $table->unsignedBigInteger('advisory_detail_id');
            $table->unsignedBigInteger('subject_id');
            $table->dateTime('schedule');
            $table->string('classroom', 10)->nullable();
            $table->string('building', 10)->nullable();
            $table->string('assignment_file', 45)->nullable();

            $table->foreign('teacher_user')->references('teacher_user')->on('teachers')->onDelete('cascade');
            $table->foreign('advisory_detail_id')->references('advisory_detail_id')->on('advisory_details')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisories');
    }
};
