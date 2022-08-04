<?php

namespace App\PivotModels\Catalog;

use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use App\Models\Catalog\Product;

class BasketProduct
{
    public string $productId;
    public int $count;

    public function create(string $productId, int $count): self
    {
        $basketProduct = new self();
        $basketProduct->productId = $productId;
        $basketProduct->count = $count;

        return $basketProduct;
    }

    public function fromArray(array $value): self
    {
        $basketProduct = new self();
        $basketProduct->productId = MongoMapper::fromMongoUuid($value['productId']);
        $basketProduct->count = $value['count'];

        return $basketProduct;
    }

    /**
     * @throws AppException
     */
    public function toArray(BasketProduct $value): array
    {
        return [
            'productId' => MongoMapper::toMongoUuid($value->productId),
            'count' => $value->count
        ];
    }

    /**
     * @throws AppException
     */
    public function product()
    {
        return Product::query()->where('_id', '=', MongoMapper::toMongoUuid($this->productId))->get();
    }
}
