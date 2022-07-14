<?php

namespace App\Http\Controllers\Admin;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\EntityServices\Admin\ProductManagementEntityService;
use App\EntityServices\Catalog\CatalogEntityService;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\ProductCreationRequest;
use App\Http\Requests\Catalog\ProductUpdateRequest;
use Illuminate\Http\JsonResponse;

class ProductManagementController extends Controller
{
    public function getList(): JsonResponse
    {
        return response()->json(CatalogEntityService::getList());
    }

    public function getCreateData(): JsonResponse
    {
        return response()->json(ProductManagementEntityService::getCreateData());
    }

    public function store(ProductCreationRequest $request): JsonResponse
    {
        $productFormDto = ProductCreateDto::fromRequest($request);

        return response()->json(
            ProductManagementEntityService::store($productFormDto),
            HTTPResponseStatuses::CREATED
        );
    }

    public function getUpdateData(int $id): JsonResponse
    {
        return response()->json(ProductManagementEntityService::getUpdateData($id));
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $productFormDto = ProductUpdateDto::fromRequest($request);

        return response()->json(ProductManagementEntityService::update($productFormDto, $id));
    }
}
