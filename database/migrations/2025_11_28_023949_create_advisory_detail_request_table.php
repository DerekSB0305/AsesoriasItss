<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advisory_detail_request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('advisory_detail_id');
            $table->unsignedBigInteger('request_id');
            $table->timestamps();

            $table->foreign('advisory_detail_id')
                ->references('advisory_detail_id')
                ->on('advisory_details')
                ->onDelete('cascade');

            $table->foreign('request_id')
                ->references('request_id')
                ->on('requests')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advisory_detail_request');
    }
};
