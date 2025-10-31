<?php

namespace App\Modules\Vacantes\Services;

use App\Modules\Vacantes\Models\Vacante;
use App\Modules\Vacantes\Models\Postulation;
use Illuminate\Support\Facades\DB;

class StatsService
{
    //ESTADÍSTICAS PERSONALES (USUARIO)
    
    public function getUserStats($userId)
    {
        $totalPostulaciones = Postulation::where('idUser', $userId)->count();
        
        $pendientes = Postulation::where('idUser', $userId)
            ->where('status', 'Pendiente')
            ->count();
            
        $aceptadas = Postulation::where('idUser', $userId)
            ->where('status', 'Aceptada')
            ->count();
            
        $rechazadas = Postulation::where('idUser', $userId)
            ->where('status', 'Rechazada')
            ->count();
        
        $enProceso = Postulation::where('idUser', $userId)
            ->where('status', 'En proceso')
            ->count();
        
        // Última postulación
        $ultimaPostulacion = Postulation::where('idUser', $userId)
            ->with('vacante:idVacant,title,idCompany,salary')
            ->orderBy('postDate', 'desc')
            ->first();
        
        // Postulaciones recientes (últimas 5)
        $recientes = Postulation::where('idUser', $userId)
            ->with('vacante:idVacant,title,idCompany,salary')
            ->orderBy('postDate', 'desc')
            ->take(5)
            ->get()
            ->map(function($p) {
                return [
                    'id' => $p->idPostulation,
                    'vacante_id' => $p->idVacant,
                    'vacante_title' => $p->vacante->title ?? null,
                    'status' => $p->status,
                    'fecha' => $p->postDate,
                ];
            });
        
        return [
            'usuario_id' => $userId,
            'resumen' => [
                'total_postulaciones' => $totalPostulaciones,
                'pendientes' => $pendientes,
                'aceptadas' => $aceptadas,
                'rechazadas' => $rechazadas,
                'en_proceso' => $enProceso,
                'tasa_exito' => $totalPostulaciones > 0 
                    ? round(($aceptadas / $totalPostulaciones) * 100, 2) 
                    : 0,
            ],
            'ultima_postulacion' => $ultimaPostulacion ? [
                'id' => $ultimaPostulacion->idPostulation,
                'vacante_id' => $ultimaPostulacion->idVacant,
                'vacante_title' => $ultimaPostulacion->vacante->title ?? null,
                'status' => $ultimaPostulacion->status,
                'fecha' => $ultimaPostulacion->postDate,
            ] : null,
            'postulaciones_recientes' => $recientes,
        ];
    }

    // Postulaciones del usuario con filtros

    public function getUserPostulations($userId, array $filters)
    {
        $query = Postulation::where('idUser', $userId)
            ->with(['vacante:idVacant,title,salary,location,idCompany']);
        
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        $query->orderBy('postDate', 'desc');
        
        return $query->get()->map(function($p) {
            return [
                'id' => $p->idPostulation,
                'vacante' => [
                    'id' => $p->idVacant,
                    'title' => $p->vacante->title ?? null,
                    'salary' => $p->vacante->salary ?? null,
                    'location' => $p->vacante->location ?? null,
                ],
                'status' => $p->status,
                'fecha' => $p->postDate,
            ];
        });
    }

    //ESTADÍSTICAS GLOBALES (ADMIN)
    
    // Estadísticas globales del sistema
     
    public function getGlobalStats()
    {
        $totalVacantes = Vacante::count();
        $vacantesActivas = Vacante::where('idState', 1)->count();
        $vacantesPausadas = Vacante::where('idState', 2)->count();
        $vacantesCerradas = Vacante::where('idState', 3)->count();
        
        $totalPostulaciones = Postulation::count();
        $postulacionesPendientes = Postulation::where('status', 'Pendiente')->count();
        $postulacionesAceptadas = Postulation::where('status', 'Aceptada')->count();
        $postulacionesRechazadas = Postulation::where('status', 'Rechazada')->count();
        
        return [
            'vacantes' => [
                'total' => $totalVacantes,
                'activas' => $vacantesActivas,
                'pausadas' => $vacantesPausadas,
                'cerradas' => $vacantesCerradas,
                'porcentaje_activas' => $totalVacantes > 0 
                    ? round(($vacantesActivas / $totalVacantes) * 100, 2) 
                    : 0,
            ],
            'postulaciones' => [
                'total' => $totalPostulaciones,
                'pendientes' => $postulacionesPendientes,
                'aceptadas' => $postulacionesAceptadas,
                'rechazadas' => $postulacionesRechazadas,
                'tasa_conversion' => $totalPostulaciones > 0
                    ? round(($postulacionesAceptadas / $totalPostulaciones) * 100, 2)
                    : 0,
            ],
        ];
    }

    // Dashboard completo 
    public function getDashboard()
    {
        $globalStats = $this->getGlobalStats();
        
        // Vacante más popular
        $vacantePopular = Vacante::withCount('postulations')
            ->orderBy('postulations_count', 'desc')
            ->first();
        
        // Salario promedio
        $salarioPromedio = Vacante::avg('salary');
        $salarioMin = Vacante::min('salary');
        $salarioMax = Vacante::max('salary');
        
        // Distribución por modalidad
        $porModalidad = Vacante::select('idModality', DB::raw('count(*) as total'))
            ->groupBy('idModality')
            ->get();
        
        // Distribución por tipo de contrato
        $porTipoContrato = Vacante::select('typeContract', DB::raw('count(*) as total'))
            ->groupBy('typeContract')
            ->get();
        
        // Vacantes creadas en los últimos 6 meses
        $vacantesPorMes = Vacante::select(
                DB::raw('YEAR(vacDate) as year'),
                DB::raw('MONTH(vacDate) as month'),
                DB::raw('count(*) as total')
            )
            ->where('vacDate', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();
        
        // Top 5 empresas con más vacantes
        $topEmpresas = Vacante::select('idCompany', DB::raw('count(*) as total'))
            ->groupBy('idCompany')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
        
        return [
            'resumen_general' => $globalStats,
            'metricas' => [
                'salario_promedio' => round($salarioPromedio, 2),
                'salario_minimo' => round($salarioMin, 2),
                'salario_maximo' => round($salarioMax, 2),
                'vacante_mas_popular' => $vacantePopular ? [
                    'id' => $vacantePopular->idVacant,
                    'title' => $vacantePopular->title,
                    'postulaciones' => $vacantePopular->postulations_count,
                ] : null,
            ],
            'distribucion' => [
                'por_modalidad' => $porModalidad,
                'por_tipo_contrato' => $porTipoContrato,
                'por_mes' => $vacantesPorMes,
            ],
            'top_empresas' => $topEmpresas,
        ];
    }

    // Reporte completo con paginación
    
    public function getReport(array $filters)
    {
        $query = Vacante::withCount('postulations');
        
        // Aplicar filtros
        if (isset($filters['idState'])) {
            $query->where('idState', $filters['idState']);
        }
        
        if (isset($filters['idCompany'])) {
            $query->where('idCompany', $filters['idCompany']);
        }
        
        $perPage = $filters['perPage'] ?? 50;
        return $query->orderBy('idVacant', 'desc')->paginate($perPage);
    }

    // ESTADÍSTICAS POR EMPRESA
    
    // Estadísticas de una empresa específica
     
    public function getCompanyStats($companyId)
    {
        $totalVacantes = Vacante::where('idCompany', $companyId)->count();
        $vacantesActivas = Vacante::where('idCompany', $companyId)
            ->where('idState', 1)
            ->count();
        
        $totalPostulaciones = Postulation::where('idCompany', $companyId)->count();
        $postulacionesPendientes = Postulation::where('idCompany', $companyId)
            ->where('status', 'Pendiente')
            ->count();
        
        // Vacante más popular de la empresa
        $vacantePopular = Vacante::where('idCompany', $companyId)
            ->withCount('postulations')
            ->orderBy('postulations_count', 'desc')
            ->first();
        
        // Promedio de postulaciones por vacante
        $promedioPostulaciones = $totalVacantes > 0 
            ? round($totalPostulaciones / $totalVacantes, 2) 
            : 0;
        
        return [
            'empresa_id' => $companyId,
            'vacantes' => [
                'total' => $totalVacantes,
                'activas' => $vacantesActivas,
            ],
            'postulaciones' => [
                'total' => $totalPostulaciones,
                'pendientes' => $postulacionesPendientes,
                'promedio_por_vacante' => $promedioPostulaciones,
            ],
            'vacante_mas_popular' => $vacantePopular ? [
                'id' => $vacantePopular->idVacant,
                'title' => $vacantePopular->title,
                'postulaciones' => $vacantePopular->postulations_count,
            ] : null,
        ];
    }
}