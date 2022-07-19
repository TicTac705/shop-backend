<?php

namespace App\Services\Catalog;

use App\Exceptions\Basket\BasketNotExistingException;
use App\Models\Catalog\Basket;
use App\Models\Catalog\Product;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;

class BasketService
{
    public function getUserBasket(User $user): Basket
    {
        $baskets = $user->baskets()->getResults();
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

    public function checkItem(Basket $basket, int $itemId): bool
    {
        $items = $basket->items()->getResults();

        if ($items->isEmpty()) {
            return false;
        }

        return $items->where('product_id', '=', $itemId)->isNotEmpty();
    }

    public function updateQuantityItem(Basket $basket, int $productId, ?int $quantity = null): BasketProduct
    {
        /** @var BasketProduct $item */
        $item = $basket->items()->where('product_id', '=', $productId)->first();

        if ($quantity !== null) {
            $item->setCount($quantity);
        } else {
            $item->setCount($item->getCount() + 1);
        }

        if ($item->isDirty()) {
            $item->touch();
            return $item->saveAndReturn();
        }

        return $item;
    }

    public function addItem(Basket $basket, int $productId): BasketProduct
    {
        $product = ProductService::getById($productId);

        return self::createItem($basket, $product, 1);
    }

    public function createItem(Basket $basket, Product $product, int $quantity): BasketProduct
    {
        return BasketProduct::create(
            $basket->getId(),
            $product->getId(),
            $quantity
        )->saveAndReturn();
    }

    public function deleteItem(Basket $basket, int $productId): void
    {
        $basket->items()->where('product_id', '=', $productId)->delete();
    }

    /**
     * @throws BasketNotExistingException
     */
    public function getBasketById(int $id): Basket
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
    public function deactivateBasket(int $id): void
    {
        $basket = $this->getBasketById($id);

        $basket->setActive(false);

        $basket->checkChangesAndSave();
    }
}
