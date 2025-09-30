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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->string('tipo_residuo'); // Enum: FO, FV, INORGANICO, PELIGROSO
            $table->boolean('programada')->default(false);
            $table->date('fecha_programada')->nullable();
            $table->integer('turno_num')->nullable();
            $table->decimal('peso_kg', 8, 2)->nullable();
            $table->string('estado')->default('pendiente'); // Enum: pendiente, programada, realizada, cancelada
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
