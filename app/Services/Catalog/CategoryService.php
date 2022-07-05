<?php
namespace App\Services\Catalog;

use App\PivotModels\Catalog\ProductCategory;

class CategoryService
{
    public function saveManyRelationship(array $categories, int $productId): void
    {
        $records = [];
        foreach ($categories as $category) {
            $records[] = [
                'product_id' => $productId,
                'category_id' => $category
            ];
        }

        ProductCategory::insert($records);
    }
}
