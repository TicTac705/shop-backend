<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Models\Catalog\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

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

    public function update(Product $model, ProductUpdateDto $data): Product
    {
        if ($data->name) {
            $model->setName($data->name);
        }

        if ($data->description) {
            $model->setDescription($data->description);
        }

        if ($data->price) {
            $model->setPrice($data->price);
        }

        if ($data->unitMeasureId) {
            $model->setUnitMeasureId($data->unitMeasureId);
        }

        if ($data->store) {
            $model->setStore($data->store);
        }

        if ($model->isDirty() || $data->haveNewImages) {
            $model->touch();
            return $model->saveAndReturn();
        }

        return $model;
    }

    public function getById(int $id): Product
    {
        return Product::query()->findOrFail($id);
    }

    public function getListWithPagination(int $numberItemsPerPage): LengthAwarePaginator
    {
        return Product::paginate($numberItemsPerPage);
    }
}
