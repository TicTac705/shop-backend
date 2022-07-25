<?php

namespace Tests\Helpers;

use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Collection;

trait ProductTrait
{
    use CategoryTrait, UnitMeasureTrait;

    protected Collection $products;

    public function createDefaultsProducts(): void
    {
        $this->products = Product::factory()->count(10)->for($this->unitMeasures->first())->hasAttached($this->categories)->create();
    }
}
