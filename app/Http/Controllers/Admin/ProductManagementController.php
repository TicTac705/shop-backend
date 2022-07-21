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
    private CatalogEntityService $catalogEntityService;
    private ProductManagementEntityService $productManagementEntityService;

    public function __construct(
        CatalogEntityService           $catalogEntityService,
        ProductManagementEntityService $productManagementEntityService
    )
    {
        $this->catalogEntityService = $catalogEntityService;
        $this->productManagementEntityService = $productManagementEntityService;
    }

    public function getList(): JsonResponse
    {
        return response()->json($this->catalogEntityService->getListFromManagement());
    }

    public function getCreateData(): JsonResponse
    {
        return response()->json($this->productManagementEntityService->getCreateData());
    }

    public function store(ProductCreationRequest $request): JsonResponse
    {
        $productFormDto = ProductCreateDto::fromRequest($request);

        return response()->json(
            $this->productManagementEntityService->store($productFormDto),
            HTTPResponseStatuses::CREATED
        );
    }

    public function getUpdateData(int $id): JsonResponse
    {
        return response()->json($this->productManagementEntityService->getUpdateData($id));
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $productFormDto = ProductUpdateDto::fromRequest($request);

        return response()->json($this->productManagementEntityService->update($id, $productFormDto));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->productManagementEntityService->destroy($id);

        return response()->json(['message' => 'Product successfully deleted.']);
    }
}
