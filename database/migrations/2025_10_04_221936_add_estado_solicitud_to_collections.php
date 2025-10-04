
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
            // Agregar campo estado_solicitud para recolecciones peligrosas
            $table->string('estado_solicitud')->nullable()->after('estado')
                ->comment('Estados: solicitado, aprobado, rechazado, programado, completado');
            
            // Agregar campos para tracking de solicitudes
            $table->timestamp('fecha_solicitud')->nullable()->after('estado_solicitud');
            $table->timestamp('fecha_aprobacion')->nullable()->after('fecha_solicitud');
            $table->foreignId('aprobado_por')->nullable()->constrained('users')->after('fecha_aprobacion');
            $table->text('motivo_rechazo')->nullable()->after('aprobado_por');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collections', function (Blueprint $table) {
            $table->dropForeign(['aprobado_por']);
            $table->dropColumn([
                'estado_solicitud',
                'fecha_solicitud',
                'fecha_aprobacion',
                'aprobado_por',
                'motivo_rechazo'
            ]);
        });
    }
};
