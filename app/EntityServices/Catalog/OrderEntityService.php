<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\OrderCreationFormDto;
use App\Exceptions\BasketNotExistingException;
use App\Services\Catalog\BasketService;
use Illuminate\Support\Facades\Auth;

class OrderEntityService
{
    private BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }


    /**
     * @throws BasketNotExistingException
     */
    public function create(OrderCreationFormDto $dto)
    {
        $user = Auth::user();

        $basket = $this->basketService->getBasketByIdToCreateOrder($dto->basketId);


    }
}
