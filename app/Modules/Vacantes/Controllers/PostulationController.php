<?php

namespace App\Modules\Vacantes\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Vacantes\Models\Postulation;
use App\Modules\Vacantes\Resources\PostulationResource;
use App\Modules\Vacantes\Resources\PostulationCollection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostulationController extends Controller
{
    // Listar todas las postulaciones
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Postulation::query()->with(['vacante', 'user', 'program']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $postulations = $query->orderBy('idPostulation', 'desc')->paginate(20);

            return response()->json(new PostulationCollection($postulations));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las postulaciones',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Obtener una postulación específica
    public function show($id): JsonResponse
    {
        try {
            $postulation = Postulation::with(['vacante', 'user', 'program'])->find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada',
                ], 404);
            }

            return response()->json([
                'success'     => true,
                'postulation' => new PostulationResource($postulation),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la postulación',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Postulaciones de un usuario específico
    public function byUser($userId): JsonResponse
    {
        try {
            $postulations = Postulation::with(['vacante', 'program'])
                ->where('idUser', $userId)
                ->orderBy('idPostulation', 'desc')
                ->get();

            return response()->json([
                'success'      => true,
                'postulations' => PostulationResource::collection($postulations),
                'total'        => $postulations->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las postulaciones del usuario',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Postulaciones de una vacante específica
    // => Aquí se cumple: ver postulantes de una vacante (nombre, foto, carrera, cv)
    public function byVacante($vacanteId): JsonResponse
    {
        try {
            $postulations = Postulation::with(['user', 'program', 'vacante'])
                ->where('idVacant', $vacanteId)
                ->orderBy('idPostulation', 'desc')
                ->get();

            return response()->json([
                'success'      => true,
                'postulations' => PostulationResource::collection($postulations),
                'total'        => $postulations->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las postulaciones de la vacante',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Actualizar estado de la postulación (Pendiente, Aceptada, Rechazada)
    public function updateStatus(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|string|max:50',
            ]);

            $postulation = Postulation::find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada',
                ], 404);
            }

            $postulation->update(['status' => $request->status]);

            return response()->json([
                'success'     => true,
                'message'     => 'Estado actualizado exitosamente',
                'postulation' => new PostulationResource($postulation),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Finalizar prácticas (atajo: status = 'Aceptada')
    public function finish($id): JsonResponse
    {
        try {
            $postulation = Postulation::find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada',
                ], 404);
            }

            $postulation->update(['status' => 'Aceptada']);

            return response()->json([
                'success'     => true,
                'message'     => 'Prácticas finalizadas para esta postulación',
                'postulation' => new PostulationResource($postulation),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al finalizar las prácticas',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    // Eliminar postulación
    public function destroy($id): JsonResponse
    {
        try {
            $postulation = Postulation::find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada',
                ], 404);
            }

            $postulation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Postulación eliminada exitosamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la postulación',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}

