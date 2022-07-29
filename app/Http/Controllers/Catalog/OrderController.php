<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\EntityServices\Catalog\OrderEntityService;
use App\Exceptions\Basket\BasketEmptyException;
use App\Exceptions\Basket\BasketNotExistingException;
use App\Exceptions\Order\NoRightsRecallOrderException;
use App\Exceptions\Order\OrderCannotRecalledException;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\OrderCreationRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    private OrderEntityService $orderEntityService;

    public function __construct(OrderEntityService $orderEntityService)
    {
        $this->orderEntityService = $orderEntityService;
    }

    public function getList(): JsonResponse
    {
        return response()->json($this->orderEntityService->getList());
    }

    /**
     * @throws BasketNotExistingException
     * @throws BasketEmptyException
     */
    public function create(OrderCreationRequest $request): JsonResponse
    {
        $orderCreationFormDto = OrderCreationFormDto::fromRequest($request);

        return response()->json($this->orderEntityService->create($orderCreationFormDto), HTTPResponseStatuses::CREATED);
    }

    /**
     * @throws NoRightsRecallOrderException
     * @throws OrderCannotRecalledException
     */
    public function recall(string $id)
    {
        $this->orderEntityService->recall($id);

        return response()->json(['message' => 'Order successfully recalled']);
    }
}
