<?php

namespace App\Services\Catalog;

use App\Exceptions\AppException;
use App\Exceptions\Basket\BasketNotExistingException;
use App\Exceptions\Catalog\InvalidQuantityProductException;
use App\Exceptions\Catalog\UnavailabilityException;
use App\Helpers\Mappers\MongoMapper;
use App\Models\Catalog\Basket;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;

class BasketService
{
    /**
     * @throws AppException
     */
    public function getUserBasket(User $user): Basket
    {
        $baskets = $user->baskets();
        $basket = null;

        if ($baskets->isNotEmpty()) {
            $basket = $baskets->where('is_active', '=', true)->first();
        }

        if ($basket === null) {
            return self::createUserBasket($user);
        }

        return $basket;
    }

    public function createUserBasket(User $user): Basket
    {
        return Basket::create($user->getId())->saveAndReturn();
    }

    public function checkItem(Basket $basket, string $itemId): bool
    {
        $items = $basket->getPositions();

        if (count($items) < 1) {
            return false;
        }

        foreach ($items as $item) {
            if ($item->productId === $itemId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws InvalidQuantityProductException
     * @throws UnavailabilityException
     * @throws  AppException
     */
    public function updateQuantityItem(Basket $basket, string $productId, ?int $quantity = null): Basket
    {
        $product = ProductService::getById($productId);

        $items = $basket->getPositions();

        $basketItemKey = null;
        foreach ($items as $key => $item) {
            if ($item->productId === $productId) {
                $basketItemKey = $key;
            }
        }

        if (!$product->getIsActive()) {
            unset($items[$basketItemKey]);
            $basket->setPositions($items);
            throw new UnavailabilityException();
        }

        if ($product->getStore() < 1) {
            unset($items[$basketItemKey]);
            $basket->setPositions($items);
            throw new InvalidQuantityProductException();
        }

        if ($quantity !== null) {
            if ($product->getStore() < $quantity) {
                throw new InvalidQuantityProductException();
            }
            $items[$basketItemKey]->count = $quantity;
        } else {
            $items[$basketItemKey]->count = $items[$basketItemKey]->count + 1;
        }

        $basket->setPositions($items);

        return $basket->checkChangesSaveAndReturn();
    }

    /**
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
     * @throws AppException
     */
    public function addItem(Basket $basket, string $productId): Basket
    {
        $product = ProductService::getById($productId);

        if (!$product->getIsActive()) {
            throw new UnavailabilityException();
        }

        if ($product->getStore() < 1) {
            throw new InvalidQuantityProductException();
        }

        $items = $basket->getPositions();
        $items[] = BasketProduct::create($productId, 1);
        $basket->setPositions($items);

        $basket->checkChangesAndSave();

        return $basket;
    }

    public function deleteItem(Basket $basket, string $productId): void
    {
        $items = $basket->getPositions();

        $basketItemKey = null;
        foreach ($items as $key => $item) {
            if ($item->productId === $productId) {
                $basketItemKey = $key;
            }
        }

        if ($basketItemKey !== null) {
            unset($items[$basketItemKey]);
        }

        $basket->setPositions($items);
        $basket->checkChangesAndSave();
    }

    /**
     * @throws BasketNotExistingException
     */
    public function getBasketById(string $id): Basket
    {
        $basket = Basket::query()->findOrFail($id)->where('is_active', '=', true)->first();

        if ($basket === null) {
            throw new BasketNotExistingException();
        }

        return $basket;
    }

    /**
     * @throws BasketNotExistingException
     */
    public function deactivateBasket(string $id): void
    {
        $basket = $this->getBasketById($id);

        $basket->setActive(false);

        $basket->checkChangesAndSave();
    }
}
