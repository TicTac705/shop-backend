<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\Dto\Catalog\OrderDto;
use App\Exceptions\BasketNotExistingException;
use App\Services\Catalog\OrderService;

class OrderEntityService
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * @throws BasketNotExistingException
     */
    public function create(OrderCreationFormDto $dto): OrderDto
    {
        return $this->orderService->create($dto);
    }
}
