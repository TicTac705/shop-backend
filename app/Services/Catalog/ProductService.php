<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\Collection;
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
            $data->categories,
            $data->userId,
            $data->isActive,
            $data->imagesId
        )->saveAndReturn();
    }

    /**
     * @throws AppException
     */
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

        if ($data->imagesId) {
            $model->setImages(array_merge($model->getImages(), $data->imagesId));
        }

        $model->setCategories($data->categories);

        if ($model->isDirty()) {
            $model->touch();
            return $model->saveAndReturn();
        }

        return $model;
    }

    /**
     * @throws AppException
     */
    public function getById(string $id): Product
    {
        return Product::getById($id);
    }

    /**
     * @param string[] $ids
     */
    public function destroyByIds(array $ids)
    {
        Product::query()->whereIn('_id', MongoMapper::toMongoUuidArray($ids))->delete();
    }

    public function getListWithPagination(int $numberItemsPerPage): LengthAwarePaginator
    {
        return Product::getListWithPagination($numberItemsPerPage);
    }

    public function getListWithPaginationFromManagement(int $numberItemsPerPage): LengthAwarePaginator
    {
        return Product::getListWithPagination($numberItemsPerPage, true);
    }

    public function destroy(Product $model): void
    {
        $model->delete();
    }

    public function deleteImage(string $id): void
    {
        /** @var Product[] $products */
        $products = Product::query()->where('image_ids', 'all', [$id])->get()->all();

        foreach ($products as $product) {
            $imageIds = $product->getImages();
            foreach ($imageIds as $key => $imageId) {
                if ($id === $imageId) {
                    unset($imageIds[$key]);
                }
            }
            $product->setImages($imageIds);

            $product->checkChangesSaveAndReturn();
        }
    }
}
