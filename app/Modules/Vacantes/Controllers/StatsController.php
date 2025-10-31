<?php

namespace App\Modules\Vacantes\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Vacantes\Services\StatsService;
use App\Modules\Vacantes\Resources\VacanteStatsCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StatsController extends Controller
{
    protected $statsService;

    public function __construct(StatsService $statsService)
    {
        $this->statsService = $statsService;
    }

    //Estadísticas PERSONALES del usuario
    public function myStats(Request $request): JsonResponse
    {
        try {
            $userId = $request->get('userId'); // temporal
            
            $stats = $this->statsService->getUserStats($userId);
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas personales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Estadísticas GLOBALES del sistema
    public function globalStats(): JsonResponse
    {
        try {
            $stats = $this->statsService->getGlobalStats();
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas globales',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Dashboard completo 
    public function dashboard(): JsonResponse
    {
        try {
            $dashboard = $this->statsService->getDashboard();
            
            return response()->json([
                'success' => true,
                'dashboard' => $dashboard
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener dashboard',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Reporte de vacantes con paginación
    public function report(Request $request): JsonResponse
    {
        try {
            $report = $this->statsService->getReport($request->all());
            
            return response()->json([
                'success' => true,
                ...(new VacanteStatsCollection($report))->resolve()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener reporte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Estadísticas de una empresa específica

    public function companyStats($companyId): JsonResponse
    {
        try {
            $stats = $this->statsService->getCompanyStats($companyId);
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas de empresa',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Postulaciones de un usuario específico

    public function userPostulations($userId, Request $request): JsonResponse
    {
        try {
            $postulations = $this->statsService->getUserPostulations($userId, $request->all());
            
            return response()->json([
                'success' => true,
                'postulations' => $postulations
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener postulaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}