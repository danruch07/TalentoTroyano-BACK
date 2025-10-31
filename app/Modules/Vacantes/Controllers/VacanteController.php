<?php

namespace App\Modules\Vacantes\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Vacantes\Models\Vacante;
use App\Modules\Vacantes\Requests\StoreVacanteRequest;
use App\Modules\Vacantes\Requests\UpdateVacanteRequest;
use App\Modules\Vacantes\Services\VacanteService;
use App\Modules\Vacantes\Resources\VacanteListCollection;
use App\Modules\Vacantes\Resources\VacanteDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VacanteController extends Controller
{
    protected $vacanteService;

    public function __construct(VacanteService $vacanteService)
    {
        $this->vacanteService = $vacanteService;
    }

    // Crear vacante
    public function store(StoreVacanteRequest $request): JsonResponse
    {
        try {
            $vacante = $this->vacanteService->createVacante($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Vacante creada exitosamente',
                'vacante' => new VacanteDetailResource($vacante)
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la vacante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Listar vacantes para SIDEBAR
    public function index(Request $request): JsonResponse
    {
        try {
            $vacantes = $this->vacanteService->getVacantes($request->all());
            
            return response()->json([
                'success' => true,
                ...(new VacanteListCollection($vacantes))->resolve()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las vacantes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Ver DETALLE completo de una vacante (panel derecho)
    public function show($id): JsonResponse
    {
        try {
            $vacante = $this->vacanteService->getVacanteById($id);

            if (!$vacante) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vacante no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'vacante' => new VacanteDetailResource($vacante)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la vacante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Solicitar vacante
    public function solicitar(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'idUser' => 'required|integer'
            ]);

            $result = $this->vacanteService->solicitarVacante($id, $request->idUser);

            if (!$result['success']) {
                return response()->json($result, $result['message'] === 'Vacante no encontrada' ? 404 : 400);
            }

            return response()->json([
                'success' => true,
                'message' => $result['message'],
                'vacante' => new VacanteDetailResource($result['data']['vacante']),
                'postulation' => $result['data']['postulation']
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al solicitar la vacante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Actualizar estado de la vacante
    public function actualizarEstado(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'idState' => 'required|integer'
            ]);

            $vacante = $this->vacanteService->updateEstado($id, $request->idState);

            if (!$vacante) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vacante no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'vacante' => new VacanteDetailResource($vacante)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Actualizar vacante completa
    public function update(UpdateVacanteRequest $request, $id): JsonResponse
    {
        try {
            $vacante = $this->vacanteService->updateVacante($id, $request->validated());

            if (!$vacante) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vacante no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Vacante actualizada exitosamente',
                'vacante' => new VacanteDetailResource($vacante)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la vacante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Eliminar vacante
    public function destroy($id): JsonResponse
    {
        try {
            $result = $this->vacanteService->deleteVacante($id);

            if (!$result['success']) {
                return response()->json($result, 404);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la vacante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Filtrado y búsqueda avanzada
    public function busquedaAvanzada(Request $request): JsonResponse
    {
        try {
            $vacantes = $this->vacanteService->busquedaAvanzada($request->all());
            $collection = new VacanteListCollection($vacantes);

            return response()->json([
                'success' => true,
                ...$collection->resolve()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda avanzada',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}