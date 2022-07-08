<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
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

    /**
     * @param array<int> $categoryIds
     * @param int $productId
     * @return void
     */
    public function updateManyRelationshipToProduct(array $categoryIds, int $productId): void
    {
        $records = [];

        $categories = Product::find($productId)->categories;

        $categoriesToBeRemoved = null;
        $categoriesThatRemain = null;

        if ($categories->isNotEmpty()) {
            $categoriesToBeRemoved = $categories->whereNotIn('id', $categoryIds)->mapWithKeys(
                function (Category $item, $key): array {
                    return [$item->id];
                }
            );

            $categoriesThatRemain = $categories->whereIn('id', $categoryIds)->mapWithKeys(function (Category $item, $key): array {
                return [$item->id];
            });
        }

        if ($categoriesToBeRemoved->isNotEmpty()) {
            ProductCategory::deleteManyByIds($categoriesToBeRemoved);
        }

        if ($categoriesThatRemain->isNotEmpty()) {
            $categoryIds = array_diff($categoryIds, $categoriesThatRemain);
        }

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
