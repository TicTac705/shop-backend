<?php

namespace App\Http\Controllers\User;

use App\Dto\Catalog\OrderCreationFormDto;
use App\EntityServices\Catalog\OrderEntityService;
use App\Exceptions\BasketNotExistingException;
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


    public function getList()
    {

    }

    /**
     * @throws BasketNotExistingException
     */
    public function create(OrderCreationRequest $request): JsonResponse
    {
        $orderCreationFormDto = OrderCreationFormDto::fromRequest($request);

        return response()->json($this->orderEntityService->create($orderCreationFormDto), HTTPResponseStatuses::CREATED);
    }
}
