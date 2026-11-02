<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationResource extends ResourceCollection
{
    public function __construct($resource, string $collects)
    {
        $this->collects = $collects;
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'items' => $this->collection->map->toArray($request)->values()->all(),
            'current_page' => $this->currentPage(),
            'last_page' => $this->lastPage(),
            'per_page' => $this->perPage(),
            'total' => $this->total(),
        ];
    }
}