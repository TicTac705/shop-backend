<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\BasketItemDto;
use App\Dto\Catalog\ProductAddedToBasketDto;
use App\Dto\Catalog\ProductUpdatedToBasketDto;
use App\Exceptions\NonExistingBasketItemException;
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
        return BasketDto::fromModel($this->basketService->getUserBasket(Auth::user()));
    }

    public function store(ProductAddedToBasketDto $dto): BasketItemDto
    {
        $basket = $this->basketService->getUserBasket(Auth::user());

        if ($this->basketService->checkItem($basket, $dto->productId)) {
            $item = $this->basketService->updateQuantityItem($basket, $dto->productId);
        } else {
            $item = $this->basketService->addItem($basket, $dto->productId);
        }

        return BasketItemDto::fromModel($item);
    }

    public function updateQuantity(ProductUpdatedToBasketDto $dto): BasketItemDto
    {
        $basket = $this->basketService->getUserBasket(Auth::user());

        if ($this->basketService->checkItem($basket, $dto->productId)) {
            $item = $this->basketService->updateQuantityItem($basket, $dto->productId, $dto->quantity);
        } else {
            $item = $this->basketService->addItem($basket, $dto->productId);
        }

        return BasketItemDto::fromModel($item);
    }

    /**
     * @throws NonExistingBasketItemException
     */
    public function destroy(int $productId): void
    {
        $basket = $this->basketService->getUserBasket(Auth::user());

        if (!$this->basketService->checkItem($basket, $productId)) {
            throw new NonExistingBasketItemException();
        }

        $this->basketService->deleteItem($basket, $productId);
    }
}
