<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductCreateDto;
use App\Models\Catalog\Product;

class ProductService
{
    public function save(ProductCreateDto $productFormDto): Product
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
