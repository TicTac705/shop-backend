<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductAddFormDto;
use App\Models\Catalog\Product;

class ProductService
{
    public function save(ProductAddFormDto $productFormDto): Product
    {
        return Product::create(
            $productFormDto->name,
            $productFormDto->description,
            $productFormDto->price,
            $productFormDto->unitMeasureId,
            $productFormDto->store,
            $productFormDto->userId
        )->saveAndReturn();
    }

}
