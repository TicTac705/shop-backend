<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\ProductAddedToCartDto;
use App\PivotModels\Catalog\BasketProduct;
use App\Services\Catalog\BasketService;
use Illuminate\Support\Facades\Auth;

class BasketEntityService
{
    private BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    public function getBasket(): BasketDto
    {
        return BasketDto::fromModel($this->basketService->getUserCart(Auth::user()));
    }

    public function store(ProductAddedToCartDto $dto): BasketProduct
    {
        $basket = $this->basketService->getUserCart(Auth::user());

        if ($this->basketService->checkItem($basket, $dto->productId)) {
            $item = $this->basketService->updateQuantityItem($basket, $dto->productId, $dto->quantity);
        } else {
            $item = $this->basketService->addItem($basket, $dto->productId, $dto->quantity);
        }

        return $item;
    }
}
