<?php

namespace Tests\Helpers;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait ProductTrait
{
    use CategoryTrait, UnitMeasureTrait, UserTrait;

    protected Collection $products;

    public function createDefaultsProducts(): void
    {
        $this->products = Product::factory()->count(10)->state(new Sequence(
            ['unit_measure_id' => $this->unitMeasures->first()->only('_id'), 'category_ids' => $this->categories->only('_id'), 'user_id' => $this->admin->getId()],
            ['unit_measure_id' => $this->unitMeasures->last()->only('_id'), 'category_ids' => $this->categories->only('_id'), 'user_id' => $this->admin->getId()],
        ))->create();
    }
}
