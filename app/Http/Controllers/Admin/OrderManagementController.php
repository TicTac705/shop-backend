<?php

namespace App\Http\Controllers\Admin;

use App\Dto\Catalog\OrderUpdateDto;
use App\EntityServices\Catalog\OrderEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\OrderUpdateRequest;
use Illuminate\Http\JsonResponse;

class OrderManagementController extends Controller
{
    private OrderEntityService $orderEntityService;

    public function __construct(OrderEntityService $orderEntityService)
    {
        $this->orderEntityService = $orderEntityService;
    }

    public function getList(): JsonResponse
    {
        return response()->json($this->orderEntityService->getListWithPagination(20));
    }

    public function getUpdateData(int $id): JsonResponse
    {
        return response()->json($this->orderEntityService->getUpdateData($id));
    }

    public function update(OrderUpdateRequest $request, int $id): JsonResponse
    {
        $orderUpdateDto = OrderUpdateDto::fromRequest($request);

        return response()->json($this->orderEntityService->update($id, $orderUpdateDto));
    }
}
