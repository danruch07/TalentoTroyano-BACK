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
            $query = Postulation::with(['vacante']);

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('idState')) {
                $query->where('idState', $request->idState);
            }

            if ($request->filled('idCompany')) {
                $query->where('idCompany', $request->idCompany);
            }

            $perPage = $request->get('perPage', 15);
            $postulations = $query->orderBy('idPostulation', 'desc')->paginate($perPage);
            $collection = new PostulationCollection($postulations);

            return response()->json([
                'success' => true,
                ...$collection->resolve()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las postulaciones',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Ver una postulación específica
    public function show($id): JsonResponse
    {
        try {
            $postulation = Postulation::with(['vacante'])->find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'postulation' => new PostulationResource($postulation)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la postulación',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Postulaciones de un usuario específico
    public function byUser($userId): JsonResponse
    {
        try {
            $postulations = Postulation::with(['vacante'])
                ->where('idUser', $userId)
                ->orderBy('idPostulation', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'postulations' => PostulationResource::collection($postulations),
                'total' => $postulations->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las postulaciones del usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Postulaciones de una vacante específica
    public function byVacante($vacanteId): JsonResponse
    {
        try {
            $postulations = Postulation::with(['vacante'])
                ->where('idVacant', $vacanteId)
                ->orderBy('idPostulation', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'postulations' => PostulationResource::collection($postulations),
                'total' => $postulations->count()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las postulaciones de la vacante',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Actualizar estado de la postulación
    public function updateStatus(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|string|max:50'
            ]);

            $postulation = Postulation::find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada'
                ], 404);
            }

            $postulation->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado exitosamente',
                'postulation' => new PostulationResource($postulation)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //Eliminar postulación
    public function destroy($id): JsonResponse
    {
        try {
            $postulation = Postulation::find($id);

            if (!$postulation) {
                return response()->json([
                    'success' => false,
                    'message' => 'Postulación no encontrada'
                ], 404);
            }

            $postulation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Postulación eliminada exitosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la postulación',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}