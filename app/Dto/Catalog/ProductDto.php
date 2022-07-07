<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\UnitMeasureDto;
use App\Dto\User\UserDto;
use App\Mappers\Catalog\ProductDtoMapper;
use App\Models\Catalog\Product;
use Illuminate\Support\Collection;

class ProductDto extends BaseDto
{
    use ProductDtoMapper;

    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public UnitMeasureDto $unitMeasure;
    public int $store;
    public Collection $categories;
    public Collection $images;
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
            'unitMeasure' => UnitMeasureDto::fromModel($product->unitMeasure)->only('id', 'name'),
            'store' => $product->store,
            'categories' => self::fromModelsToCollectionForCategories($product->categories->all()),
            'images' => self::fromModelsToCollectionForImages($product->images->all()),
            'creator' => UserDto::fromModel($product->user)->only('id', 'name'),
            'updatedAt' => $product->updated_at->timestamp,
            'createdAt' => $product->created_at->timestamp,
        ]);
    }
}
