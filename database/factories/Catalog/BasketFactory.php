<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Basket;
use Illuminate\Database\Eloquent\Factories\Factory;

class BasketFactory extends Factory
{
    protected $model = Basket::class;

    public function definition(): array
    {
        return [
            'user_id' => '',
            'is_active' => true,
        ];
    }
}
