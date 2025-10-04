
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
        Schema::table('collections', function (Blueprint $table) {
            $table->foreignId('localidad_id')->nullable()->after('company_id')->constrained('localidads')->onDelete('set null');
            $table->foreignId('ruta_id')->nullable()->after('localidad_id')->constrained('rutas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['localidad_id']);
            $table->dropForeign(['ruta_id']);
            $table->dropColumn(['localidad_id', 'ruta_id']);
        });
    }
};
