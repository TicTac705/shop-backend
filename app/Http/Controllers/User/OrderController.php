<?php

namespace App\Http\Controllers\User;

use App\Dto\Catalog\OrderCreationFormDto;
use App\EntityServices\Catalog\OrderEntityService;
use App\Exceptions\BasketNotExistingException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\OrderCreateRequest;

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
    public function create(OrderCreateRequest $request)
    {
        $orderCreationFormDto = OrderCreationFormDto::fromRequest($request);

        $this->orderEntityService->create($orderCreationFormDto);
    }
}
