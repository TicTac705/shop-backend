<?php

namespace Database\Factories;

use App\Models\UnitMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class UnitMeasureFactory extends Factory
{
    protected $model = UnitMeasure::class;

    public function definition(): array
    {
        return [
            'name' => '',
            'slug' => '',
        ];
    }
}
