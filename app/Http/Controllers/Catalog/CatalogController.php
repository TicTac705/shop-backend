<?php

namespace App\Http\Controllers\Catalog;

use App\EntityServices\Catalog\CatalogEntityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    private CatalogEntityService $catalogEntityService;

    public function __construct(CatalogEntityService $catalogEntityService)
    {
        $this->catalogEntityService = $catalogEntityService;
    }

    public function getList(): JsonResponse
    {
        return response()->json($this->catalogEntityService->getList());
    }
}
