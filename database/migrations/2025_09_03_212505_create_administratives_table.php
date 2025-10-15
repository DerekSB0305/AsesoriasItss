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
            $table->string('admin_user', 50)->primary(); # ID del administrativo
            $table->string('first_name', 50); # Nombre(s)
            $table->string('last_name_father', 50); # Apellido paterno
            $table->string('last_name_mother', 50); # Apellido materno
            $table->string('position', 50); # Puesto
            $table->string('channeling_sheet')->nullable(); # Hoja canalizadora
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
