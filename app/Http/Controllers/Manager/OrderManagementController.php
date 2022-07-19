<?php

namespace App\Http\Controllers\Manager;

use App\EntityServices\Catalog\OrderEntityService;
use App\Http\Controllers\Controller;
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

    public function getOrder(int $id)
    {

    }
}
