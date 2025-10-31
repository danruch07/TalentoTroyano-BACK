<?php

namespace App\Modules\Vacantes\Services;

use App\Modules\Vacantes\Models\Vacante;
use App\Modules\Vacantes\Models\Postulation;

class VacanteService
{
    // Crear una nueva vacante

    public function createVacante(array $data)
    {
        return Vacante::create($data);
    }

    //Obtener vacantes con filtros (para sidebar)
     
    public function getVacantes(array $filters)
    {
        $query = Vacante::query();

        // Filtro por estado
        if (isset($filters['idState'])) {
            $query->byState($filters['idState']);
        }

        // Filtro por modalidad
        if (isset($filters['idModality'])) {
            $query->byModality($filters['idModality']);
        }

        // Filtro por empresa
        if (isset($filters['idCompany'])) {
            $query->byCompany($filters['idCompany']);
        }

        // Filtro por tipo de contrato
        if (isset($filters['typeContract'])) {
            $query->byTypeContract($filters['typeContract']);
        }

        // Búsqueda general
        if (isset($filters['search'])) {
            $query->search($filters['search']);
        }

        // Filtro por ubicación
        if (isset($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        // Filtro por rango salarial
        if (isset($filters['salaryMin'])) {
            $salaryMax = $filters['salaryMax'] ?? null;
            $query->bySalaryRange($filters['salaryMin'], $salaryMax);
        }

        // Filtro por programa
        if (isset($filters['idPrograms'])) {
            $query->where('idPrograms', $filters['idPrograms']);
        }

        // Ordenamiento
        $sortBy = $filters['sortBy'] ?? 'idVacant';
        $sortOrder = $filters['sortOrder'] ?? 'desc';
        $query->orderBy($sortBy, $sortOrder);

        // Paginación (20 para sidebar)
        $perPage = $filters['perPage'] ?? 20;
        return $query->paginate($perPage);
    }

    // Obtener vacante por ID (para detalle completo)
    public function getVacanteById($id)
    {
        return Vacante::find($id);
    }

    // Solicitar vacante

    public function solicitarVacante($idVacante, $idUser)
    {
        $vacante = Vacante::find($idVacante);

        if (!$vacante) {
            return [
                'success' => false,
                'message' => 'Vacante no encontrada'
            ];
        }

        // Verificar si el usuario ya aplicó a esta vacante
        $existingPostulation = Postulation::where('idVacant', $idVacante)
            ->where('idUser', $idUser)
            ->first();

        if ($existingPostulation) {
            return [
                'success' => false,
                'message' => 'Ya has aplicado a esta vacante anteriormente'
            ];
        }

        // Crear la postulación
        $postulation = Postulation::create([
            'idVacant' => $vacante->idVacant,
            'idState' => $vacante->idState,
            'idUser' => $idUser,
            'idAdmin' => $vacante->idAdmin,
            'idModality' => $vacante->idModality,
            'idCompany' => $vacante->idCompany,
            'idPrograms' => $vacante->idPrograms,
            'postDate' => now()->format('Y-m-d'),
            'status' => 'Pendiente'
        ]);

        return [
            'success' => true,
            'message' => 'Solicitud enviada exitosamente',
            'data' => [
                'vacante' => $vacante,
                'postulation' => $postulation
            ]
        ];
    }

    // Actualizar estado
    public function updateEstado($id, $idState)
    {
        $vacante = Vacante::find($id);

        if (!$vacante) {
            return null;
        }

        $vacante->update(['idState' => $idState]);
        return $vacante;
    }

    // Actualizar vacante
    public function updateVacante($id, array $data)
    {
        $vacante = Vacante::find($id);

        if (!$vacante) {
            return null;
        }

        $vacante->update($data);
        return $vacante;
    }

    // Eliminar vacante
    public function deleteVacante($id)
    {
        $vacante = Vacante::find($id);

        if (!$vacante) {
            return [
                'success' => false,
                'message' => 'Vacante no encontrada'
            ];
        }

        $vacante->delete();

        return [
            'success' => true,
            'message' => 'Vacante eliminada exitosamente'
        ];
    }

    // Búsqueda avanzada
    public function busquedaAvanzada(array $filters)
    {
        $query = Vacante::query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['location'])) {
            $query->where('location', 'like', '%' . $filters['location'] . '%');
        }

        if (isset($filters['typeContract'])) {
            $query->where('typeContract', $filters['typeContract']);
        }

        if (isset($filters['salaryMin']) && isset($filters['salaryMax'])) {
            $query->whereBetween('salary', [$filters['salaryMin'], $filters['salaryMax']]);
        }

        if (isset($filters['idState'])) {
            $query->where('idState', $filters['idState']);
        }

        if (isset($filters['idModality'])) {
            $query->where('idModality', $filters['idModality']);
        }

        if (isset($filters['idCompany'])) {
            $query->where('idCompany', $filters['idCompany']);
        }

        if (isset($filters['idPrograms'])) {
            $query->where('idPrograms', $filters['idPrograms']);
        }

        if (isset($filters['generalSearch'])) {
            $query->search($filters['generalSearch']);
        }

        $perPage = $filters['perPage'] ?? 15;
        return $query->paginate($perPage);
    }
}