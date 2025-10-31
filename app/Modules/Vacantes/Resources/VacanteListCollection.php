<?php

namespace App\Modules\Vacantes\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VacanteListCollection extends ResourceCollection
{
   
    public function toArray(Request $request): array
    {
        return [
            'vacantes' => VacanteListResource::collection($this->collection),
            'pagination' => [
                'current_page' => $this->currentPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
                'last_page' => $this->lastPage(),
                'has_more' => $this->hasMorePages(),
            ],
        ];
    }
}