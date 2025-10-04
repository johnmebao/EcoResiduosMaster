
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
        Schema::create('canjes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('tienda_id')->constrained()->onDelete('cascade');
            $table->integer('puntos_canjeados');
            $table->decimal('descuento_obtenido', 8, 2);
            $table->string('codigo_canje')->unique();
            $table->enum('estado', ['pendiente', 'usado', 'expirado'])->default('pendiente');
            $table->timestamp('fecha_canje');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canjes');
    }
};
