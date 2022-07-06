<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\UnitMeasureDto;
use App\Dto\User\UserDto;
use App\Models\Catalog\Product;

class ProductDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public UnitMeasureDto $unitMeasureId;
    public int $store;
    public UserDto $creator;
    public int $updatedAt;
    public int $createdAt;


    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'unitMeasureId' => UnitMeasureDto::fromModel($product->unitMeasure)->only('id', 'name'),
            'store' => $product->store,
            'creator' => UserDto::fromModel($product->user)->only('id', 'name'),
            'updatedAt' => $product->updated_at->timestamp,
            'createdAt' => $product->created_at->timestamp,
        ]);
    }
}
