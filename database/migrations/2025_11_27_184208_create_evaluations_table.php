<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('evaluations', function (Blueprint $table) {
        $table->id();
        $table->string('enrollment'); // alumno
        $table->unsignedBigInteger('advisory_id'); // asesoría
        $table->string('teacher_user'); // maestro

        // Respuestas
        $table->tinyInteger('q1');
        $table->tinyInteger('q2');
        $table->tinyInteger('q3');
        $table->tinyInteger('q4');
        $table->tinyInteger('q5');
        $table->tinyInteger('q6');
        $table->tinyInteger('q7');
        $table->tinyInteger('q8');
        $table->tinyInteger('q9');
        $table->tinyInteger('q10');
        $table->tinyInteger('q11');

        $table->timestamps();

        // Llaves foráneas
        $table->foreign('enrollment')->references('enrollment')->on('students')->onDelete('cascade');
        $table->foreign('advisory_id')->references('advisory_id')->on('advisories')->onDelete('cascade');
        $table->foreign('teacher_user')->references('teacher_user')->on('teachers')->onDelete('cascade');

        // Evitar evaluaciones duplicadas
        $table->unique(['enrollment', 'advisory_id']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
