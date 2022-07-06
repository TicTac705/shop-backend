<?php

namespace App\Services\Catalog;

use App\PivotModels\Catalog\ProductCategory;

class CategoryService
{
    /**
     * @param array<int> $categoryIds
     * @param int $productId
     * @return void
     */
    public function saveManyRelationshipToProduct(array $categoryIds, int $productId): void
    {
        $records = [];
        foreach ($categoryIds as $categoryId) {
            $model = ProductCategory::create(
                $productId,
                $categoryId
            );
            $records[] = $model;
        }

        ProductCategory::saveMany($records);
    }
}
