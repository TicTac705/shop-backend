<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\ProductAddedToBasketDto;
use App\Dto\Catalog\ProductUpdatedToBasketDto;
use App\Exceptions\AppException;
use App\Exceptions\Basket\NonExistingBasketItemException;
use App\Exceptions\Catalog\InvalidQuantityProductException;
use App\Exceptions\Catalog\UnavailabilityException;
use App\Services\Catalog\BasketService;
use Illuminate\Support\Facades\Auth;

class BasketEntityService
{
    private BasketService $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    /**
     * @throws AppException
     */
    public function getBasket(): BasketDto
    {
        return BasketDto::fromModel($this->basketService->getUserBasket(Auth::user()));
    }

    /**
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
     * @throws AppException
     */
    public function store(ProductAddedToBasketDto $dto): BasketDto
    {
        $basket = $this->basketService->getUserBasket(Auth::user());

        if ($this->basketService->checkItem($basket, $dto->productId)) {
            $basket = $this->basketService->updateQuantityItem($basket, $dto->productId);
        } else {
            $basket = $this->basketService->addItem($basket, $dto->productId);
        }

        return BasketDto::fromModel($basket);
    }

    /**
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
     * @throws AppException
     */
    public function updateQuantity(ProductUpdatedToBasketDto $dto): BasketDto
    {
        $basket = $this->basketService->getUserBasket(Auth::user());

        if ($this->basketService->checkItem($basket, $dto->productId)) {
            $item = $this->basketService->updateQuantityItem($basket, $dto->productId, $dto->quantity);
        } else {
            $item = $this->basketService->addItem($basket, $dto->productId);
        }

        return BasketDto::fromModel($item);
    }

    /**
     * @throws NonExistingBasketItemException
     * @throws AppException
     */
    public function destroy(string $productId): void
    {
        $basket = $this->basketService->getUserBasket(Auth::user());

        if (!$this->basketService->checkItem($basket, $productId)) {
            throw new NonExistingBasketItemException();
        }

        $this->basketService->deleteItem($basket, $productId);
    }
}
