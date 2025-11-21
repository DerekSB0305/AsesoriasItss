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
            $table->unsignedBigInteger('teacher_subject_id');
            $table->unsignedBigInteger('advisory_detail_id');
            $table->date('start_date');          
            $table->date('end_date');             
            $table->string('day_of_week', 15);   
            $table->time('start_time');           
            $table->time('end_time')->nullable(); 
            $table->string('classroom', 10)->nullable();
            $table->string('building', 10)->nullable();
            $table->string('assignment_file')->nullable();

            $table->foreign('teacher_subject_id')->references('teacher_subject_id')->on('teacher_subjects')->onDelete('cascade');
            $table->foreign('advisory_detail_id')->references('advisory_detail_id')->on('advisory_details')->onDelete('cascade');
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
