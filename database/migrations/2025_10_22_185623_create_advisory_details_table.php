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
        Schema::create('advisory_details', function (Blueprint $table) {
            $table->id('advisory_detail_id');
            $table->string('enrollment', 8);
            $table->string('status', 9)->default('Pending');
            $table->string('observations', 100)->nullable();

            $table->foreign('enrollment')->references('enrollment')->on('students')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advisory_details');
    }
};
