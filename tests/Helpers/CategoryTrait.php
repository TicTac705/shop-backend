<?php

namespace Tests\Helpers;

use App\Models\Catalog\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait CategoryTrait
{
    protected Collection $categories;

    public function createDefaultsCategories():void
    {
        $this->categories = Category::factory()->count(3)->state(new Sequence(
            ['name' => 'Fruit', 'slug' => 'fruit'],
            ['name' => 'Vegetables', 'slug' => 'vegetables'],
            ['name' => 'Cereals', 'slug' => 'cereals']
        ))->create();
    }
}
