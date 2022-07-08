<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Models\Catalog\Product;

class ProductService
{
    public function save(ProductCreateDto $data): Product
    {
        return Product::create(
            $data->name,
            $data->description,
            $data->price,
            $data->unitMeasureId,
            $data->store,
            $data->userId
        )->saveAndReturn();
    }

    public function update(Product $model, ProductUpdateDto $data): ?Product
    {
        $model->setName($data->name);
        $model->setDescription($data->description);
        $model->setPrice($data->price);
        $model->setUnitMeasure($data->unitMeasureId);
        $model->setStore($data->store);

        if ($model->wasChanged() || $data->haveNewImages) {
            $model->touch();
            return $model->saveAndReturn();
        }

        return null;
    }
}
