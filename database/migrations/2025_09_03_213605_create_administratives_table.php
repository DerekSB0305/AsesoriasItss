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
        Schema::create('administratives', function (Blueprint $table) {
            $table->string('administrative_user', 50)->primary();
            $table->string('name', 40);
            $table->string('last_name_f', 50);
            $table->string('last_name_m', 50);
            $table->string('position', 50);
            $table->unsignedBigInteger('career_id')->nullable();
            $table->foreign('career_id')->references('career_id')->on('careers')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administratives');
    }
};
