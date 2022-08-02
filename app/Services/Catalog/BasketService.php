<?php

namespace App\Services\Catalog;

use App\Exceptions\Basket\BasketNotExistingException;
use App\Exceptions\Catalog\InvalidQuantityProductException;
use App\Exceptions\Catalog\UnavailabilityException;
use App\Models\Catalog\Basket;
use App\Models\Catalog\Product;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;

class BasketService
{
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
        $items = collect($basket->getPositions());

        if ($items->isEmpty()) {
            return false;
        }

        return $items->where('product_id', '=', $itemId)->isNotEmpty();
    }

    /**
     * @throws InvalidQuantityProductException
     * @throws UnavailabilityException
     */
    public function updateQuantityItem(Basket $basket, string $productId, ?int $quantity = null): BasketProduct
    {
        $product = ProductService::getById($productId);

        $item = collect($basket->getPositions())->where('product_id', '=', $productId)->first();
        dd($item);
        if (!$product->getIsActive()) {
            $this->deleteItem($basket, $productId);
            throw new UnavailabilityException();
        }

        if ($product->getStore() < 1) {
            $this->deleteItem($basket, $productId);
            throw new InvalidQuantityProductException();
        }

        if ($quantity !== null) {
            if ($product->getStore() < $quantity) {
                throw new InvalidQuantityProductException();
            }

            $item->setCount($quantity);
        } else {
            $item->setCount($item->getCount() + 1);
        }

        return $item->checkChangesSaveAndReturn();
    }

    /**
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
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

        $basket->addPosition(
            [
                'product_id' => $product->getId(),
                'quantity' => 1
            ]
        )->checkChangesAndSave();

        return $basket;
    }

    public function createItem(Basket $basket, Product $product, int $quantity): BasketProduct
    {
        return BasketProduct::create(
            $basket->getId(),
            $product->getId(),
            $quantity
        )->saveAndReturn();
    }

    public function deleteItem(Basket $basket, string $productId): void
    {
        $basket->items()->where('product_id', '=', $productId)->first()->delete();
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
