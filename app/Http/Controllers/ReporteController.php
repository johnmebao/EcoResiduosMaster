<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use App\Models\Empresa;
use App\Models\TipoResiduo;
use App\Repositories\RecoleccionRepository;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteController extends Controller
{
    protected $recoleccionRepository;

    public function __construct(RecoleccionRepository $recoleccionRepository)
    {
        $this->recoleccionRepository = $recoleccionRepository;
    }

    /**
     * Mostrar formulario de reporte por localidad
     */
    public function reportePorLocalidad(Request $request)
    {
        $localidades = Localidad::orderBy('nombre')->get();
        $tiposResiduo = TipoResiduo::orderBy('nombre')->get();

        $estadisticas = null;
        $localidadSeleccionada = null;

        if ($request->has('localidad_id')) {
            $filters = [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ];

            $estadisticas = $this->recoleccionRepository->getEstadisticasPorLocalidad(
                $request->localidad_id,
                $filters
            );

            $localidadSeleccionada = Localidad::find($request->localidad_id);
        }

        return view('admin.reportes.localidad', compact(
            'localidades',
            'tiposResiduo',
            'estadisticas',
            'localidadSeleccionada'
        ));
    }

    /**
     * Mostrar formulario de reporte por empresa
     */
    public function reportePorEmpresa(Request $request)
    {
        $empresas = Empresa::orderBy('nombre')->get();
        $tiposResiduo = TipoResiduo::orderBy('nombre')->get();

        $estadisticas = null;
        $empresaSeleccionada = null;

        if ($request->has('empresa_id')) {
            $filters = [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'tipo_residuo_id' => $request->tipo_residuo_id,
            ];

            $estadisticas = $this->recoleccionRepository->getEstadisticasPorEmpresa(
                $request->empresa_id,
                $filters
            );

            $empresaSeleccionada = Empresa::find($request->empresa_id);
        }

        return view('admin.reportes.empresa', compact(
            'empresas',
            'tiposResiduo',
            'estadisticas',
            'empresaSeleccionada'
        ));
    }

    /**
     * Exportar reporte a PDF
     */
    public function exportarPDF(Request $request)
    {
        $tipo = $request->tipo; // 'localidad' o 'empresa'
        
        if ($tipo === 'localidad') {
            $filters = [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ];

            $estadisticas = $this->recoleccionRepository->getEstadisticasPorLocalidad(
                $request->id,
                $filters
            );

            $entidad = Localidad::find($request->id);
            $titulo = 'Reporte por Localidad';
        } else {
            $filters = [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'tipo_residuo_id' => $request->tipo_residuo_id,
            ];

            $estadisticas = $this->recoleccionRepository->getEstadisticasPorEmpresa(
                $request->id,
                $filters
            );

            $entidad = Empresa::find($request->id);
            $titulo = 'Reporte por Empresa';
        }

        $pdf = Pdf::loadView('admin.reportes.pdf', compact(
            'estadisticas',
            'entidad',
            'titulo',
            'filters'
        ));

        return $pdf->download("reporte_{$tipo}_{$entidad->nombre}.pdf");
    }

    /**
     * Exportar reporte a CSV
     */
    public function exportarCSV(Request $request)
    {
        $tipo = $request->tipo; // 'localidad' o 'empresa'
        
        if ($tipo === 'localidad') {
            $filters = [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
            ];

            $estadisticas = $this->recoleccionRepository->getEstadisticasPorLocalidad(
                $request->id,
                $filters
            );

            $entidad = Localidad::find($request->id);
        } else {
            $filters = [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'tipo_residuo_id' => $request->tipo_residuo_id,
            ];

            $estadisticas = $this->recoleccionRepository->getEstadisticasPorEmpresa(
                $request->id,
                $filters
            );

            $entidad = Empresa::find($request->id);
        }

        $filename = "reporte_{$tipo}_{$entidad->nombre}.csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($estadisticas) {
            $file = fopen('php://output', 'w');
            
            // Encabezados
            fputcsv($file, ['Tipo de Residuo', 'Total Recolecciones', 'Total KG']);
            
            // Datos
            foreach ($estadisticas as $stat) {
                fputcsv($file, [
                    $stat->tipo_residuo,
                    $stat->total_recolecciones,
                    $stat->total_kg,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
