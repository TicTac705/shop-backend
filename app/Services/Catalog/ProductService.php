<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Models\Catalog\Product;
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
            $data->userId,
            $data->isActive
        )->saveAndReturn();
    }

    public function update(Product $model, ProductUpdateDto $data): Product
    {
        if (is_bool($data->isActive)) {
            $model->setIsActive($data->isActive);
        }

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
        return Product::query()->findOrFail($id)->first();
    }

    public function getListWithPagination(int $numberItemsPerPage): LengthAwarePaginator
    {
        return Product::getListWithPagination($numberItemsPerPage);
    }

    public function getListWithPaginationFromManagement(int $numberItemsPerPage): LengthAwarePaginator
    {
        return Product::getListWithPagination($numberItemsPerPage, true);
    }

    public function reduceQuantityStockByNumber(int $productId, int $number): void
    {
        $product = $this->getById($productId);

        $product->setStore($product->getStore() - $number);

        $product->checkChangesAndSave();
    }

    public function destroy(Product $model): void
    {
        $model->delete();
    }
}
