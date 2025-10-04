<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Collection;
use App\Models\Ruta;
use App\Models\Localidad;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class GenerarRecoleccionesOrganicosSemanales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recolecciones:generar-organicos-semanales 
                            {--semanas=1 : Número de semanas a generar}
                            {--dry-run : Simular sin crear registros}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar recolecciones de orgánicos semanales para todos los usuarios según su localidad y ruta';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $semanas = (int) $this->option('semanas');
        $dryRun = $this->option('dry-run');

        $this->info("🚀 Iniciando generación de recolecciones de orgánicos...");
        $this->info("📅 Semanas a generar: {$semanas}");
        
        if ($dryRun) {
            $this->warn("⚠️  Modo DRY-RUN activado - No se crearán registros");
        }

        // Obtener todos los usuarios activos
        $usuarios = User::where('activo', true)->get();
        $this->info("👥 Usuarios activos encontrados: {$usuarios->count()}");

        $recoleccionesCreadas = 0;
        $errores = 0;

        foreach ($usuarios as $usuario) {
            try {
                // Verificar que el usuario tenga localidad
                if (!$usuario->localidad_id) {
                    $this->warn("⚠️  Usuario {$usuario->id} ({$usuario->name}) no tiene localidad asignada");
                    continue;
                }

                // Obtener la ruta de orgánicos para la localidad del usuario
                $ruta = Ruta::where('localidad_id', $usuario->localidad_id)
                    ->where('activo', true)
                    ->first();

                if (!$ruta) {
                    $this->warn("⚠️  No hay ruta activa para la localidad del usuario {$usuario->id}");
                    continue;
                }

                // Obtener empresa de la ruta
                $companyId = $ruta->company_id;

                // Generar recolecciones para las próximas N semanas
                for ($i = 0; $i < $semanas; $i++) {
                    $fechaProgramada = $ruta->getProximaFechaRecoleccion()->addWeeks($i);

                    // Verificar si ya existe una recolección para esa fecha
                    $existe = Collection::where('user_id', $usuario->id)
                        ->where('tipo_residuo', Collection::TIPO_ORGANICO)
                        ->whereDate('fecha_programada', $fechaProgramada)
                        ->exists();

                    if ($existe) {
                        $this->line("   ℹ️  Ya existe recolección para usuario {$usuario->id} en {$fechaProgramada->format('Y-m-d')}");
                        continue;
                    }

                    if (!$dryRun) {
                        // Crear la recolección
                        Collection::create([
                            'user_id' => $usuario->id,
                            'company_id' => $companyId,
                            'localidad_id' => $usuario->localidad_id,
                            'ruta_id' => $ruta->id,
                            'tipo_residuo' => Collection::TIPO_ORGANICO,
                            'programada' => true,
                            'fecha_programada' => $fechaProgramada,
                            'estado' => 'programada',
                            'notas' => 'Recolección automática semanal de orgánicos',
                        ]);

                        $recoleccionesCreadas++;
                        $this->line("   ✅ Creada recolección para usuario {$usuario->id} en {$fechaProgramada->format('Y-m-d')}");
                    } else {
                        $this->line("   [DRY-RUN] Crearía recolección para usuario {$usuario->id} en {$fechaProgramada->format('Y-m-d')}");
                        $recoleccionesCreadas++;
                    }
                }

            } catch (\Exception $e) {
                $errores++;
                $this->error("❌ Error al procesar usuario {$usuario->id}: {$e->getMessage()}");
                Log::error("Error en GenerarRecoleccionesOrganicosSemanales", [
                    'user_id' => $usuario->id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        $this->newLine();
        $this->info("✨ Proceso completado");
        $this->info("📊 Recolecciones creadas: {$recoleccionesCreadas}");
        
        if ($errores > 0) {
            $this->error("⚠️  Errores encontrados: {$errores}");
        }

        Log::info("Comando GenerarRecoleccionesOrganicosSemanales ejecutado", [
            'recolecciones_creadas' => $recoleccionesCreadas,
            'errores' => $errores,
            'dry_run' => $dryRun
        ]);

        return Command::SUCCESS;
    }
}
