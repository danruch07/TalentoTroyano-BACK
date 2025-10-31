<?php

namespace App\Modules\Vacantes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VacanteStatsCollection extends ResourceCollection
{
    // Coleccion para reportes con paginación y estadísticas
    public function toArray(Request $request): array
    {
        return [
            'vacantes' => VacanteStatsResource::collection($this->collection),
            'stats' => [
                'total' => $this->total(),
                'count' => $this->count(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
            ],
            'summary' => $this->when($this->collection->isNotEmpty(), function() {
                return [
                    'total_postulaciones' => $this->collection->sum('postulations_count'),
                    'promedio_postulaciones' => round($this->collection->avg('postulations_count'), 2),
                    'salario_promedio' => round($this->collection->avg('salary'), 2),
                    'salario_minimo' => round($this->collection->min('salary'), 2),
                    'salario_maximo' => round($this->collection->max('salary'), 2),
                ];
            }),
        ];
    }
}