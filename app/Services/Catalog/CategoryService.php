<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;

class CategoryService
{
    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return Category::all()->all();
    }

    /**
     * @param int[] $categoryIds
     * @param Product $model
     * @return void
     */
    public function saveManyRelationshipToProduct(array $categoryIds, Product $model): void
    {
        $model->categories()->sync($categoryIds);
    }
}
