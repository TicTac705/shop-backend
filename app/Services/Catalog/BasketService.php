<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Basket;
use App\Models\User\User;

class BasketService
{
    public function getUserCart(User $user): Basket
    {
        $baskets = $user->baskets;
        $basket = null;

        if ($baskets->isNotEmpty()) {
            $basket = $baskets->where('is_active', '=', true)->first();
        }

        if ($basket === null) {
            return $this->createUserCart($user);
        }

        return $basket;
    }

    public function createUserCart(User $user): Basket
    {
        return Basket::create($user->id)->saveAndReturn();
    }
}
