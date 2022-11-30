<?php

namespace Database\Factories\Catalog;

use App\Models\Catalog\Product;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->realText(),
            'price' => $this->faker->randomNumber(),
            'unit_measure_id' => '',
            'store' => $this->faker->randomNumber(),
            'category_ids' => '',
            'user_id' => '',
            'is_active' => $this->faker->boolean(),
            'image_ids' => []
        ];
    }
}
