<?php

namespace App\PivotModels\Catalog;

use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use App\Models\Catalog\Product;

class OrderProduct
{
    public string $productId;
    public float $price;
    public int $count;

    public function create(string $productId, float $price, int $count): self
    {
        $basketProduct = new self();
        $basketProduct->productId = $productId;
        $basketProduct->price = $price;
        $basketProduct->count = $count;

        return $basketProduct;
    }

    public function fromArray(array $value): self
    {
        $basketProduct = new self();
        $basketProduct->productId = MongoMapper::fromMongoUuid($value['productId']);
        $basketProduct->price = $value['price'];
        $basketProduct->count = $value['count'];

        return $basketProduct;
    }

    /**
     * @throws AppException
     */
    public function toArray(OrderProduct $value): array
    {
        return [
            'productId' => MongoMapper::toMongoUuid($value->productId),
            'price' => $value->price,
            'count' => $value->count
        ];
    }

    /**
     * @throws AppException
     */
    public function product()
    {
        return Product::getByIdWithTrashed($this->productId);
    }
}
