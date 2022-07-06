<?php

namespace App\Http\Controllers\Admin;

use App\EntityServices\Admin\CatalogManagementEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\AdditionProductRequest;
use Illuminate\Http\JsonResponse;

class CatalogManagementController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    /**
     * @param AdditionProductRequest $request
     * @return JsonResponse
     */
    public function store(AdditionProductRequest $request)
    {
        return CatalogManagementEntityService::store($request);
    }
}
