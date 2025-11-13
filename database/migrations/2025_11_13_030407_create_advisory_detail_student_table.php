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
        Schema::create('advisory_detail_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advisory_detail_id');
            $table->string('enrollment',50);
            $table->foreign('advisory_detail_id')->references('advisory_detail_id')->on('advisory_details')->onDelete('cascade');
            $table->foreign('enrollment')->references('enrollment')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_detail_student');
    }
};
