<?php

namespace App\Http\Controllers\Catalog;

use App\EntityServices\Catalog\CatalogEntityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CatalogController extends Controller
{
    public function getList(): JsonResponse
    {
        return response()->json(CatalogEntityService::getList());
    }
}
