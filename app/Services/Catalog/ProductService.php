<?php

namespace App\Services\Catalog;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Models\Catalog\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

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
            $model->setUnitMeasure($data->unitMeasureId);
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

    /**
     * @param int $id
     * @return Product|JsonResponse
     */
    public function getById(int $id)
    {
        try {
            return Product::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Invalid Request'], HTTPResponseStatuses::NOT_FOUND);
        }
    }
}
