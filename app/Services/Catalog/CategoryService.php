<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Product;

class CategoryService
{
    /**
     * @param array<int> $categoryIds
     * @param Product $model
     * @return void
     */
    public function saveManyRelationshipToProduct(array $categoryIds, Product $model): void
    {
        $model->categories()->sync($categoryIds);
    }
}
