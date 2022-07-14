<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Basket;
use App\Models\Catalog\Product;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;

class BasketService
{
    public function getUserCart(User $user): Basket
    {
        $baskets = $user->baskets()->getResults();
        $basket = null;

        if ($baskets->isNotEmpty()) {
            $basket = $baskets->where('is_active', '=', true)->first();
        }

        if ($basket === null) {
            return self::createUserCart($user);
        }

        return $basket;
    }

    public function createUserCart(User $user): Basket
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

    public function updateQuantityItem(Basket $basket, int $productId, int $quantity): BasketProduct
    {
        /** @var BasketProduct $item */
        $item = $basket->items()->where('product_id', '=', $productId)->first();

        $item->setCount($quantity);

        if ($item->isDirty()) {
            $item->touch();
            return $item->saveAndReturn();
        }

        return $item;
    }

    public function addItem(Basket $basket, int $productId, int $quantity): BasketProduct
    {
        $product = ProductService::getById($productId);

        return self::createItem($basket, $product, $quantity);
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
}
