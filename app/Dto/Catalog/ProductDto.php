<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\ImageLightDto;
use App\Dto\UnitMeasureLightDto;
use App\Dto\User\UserLightDto;
use App\Exceptions\AppException;
use App\Models\Catalog\Product;

class ProductDto extends BaseDto
{
    public string $id;
    public bool $isActive;
    public string $name;
    public string $description;
    public float $price;
    public UnitMeasureLightDto $unitMeasure;
    public int $store;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categories;
    /** @var \App\Dto\ImageLightDto[] */
    public ?array $images;
    public UserLightDto $creator;
    public ?int $updatedAt;
    public ?int $createdAt;


    /**
     * @throws AppException
     */
    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->getId(),
            'isActive' => $product->getIsActive(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'unitMeasure' => UnitMeasureLightDto::fromModel($product->unitMeasure()),
            'store' => $product->getStore(),
            'categories' => CategoryLightDto::fromList($product->categories()->all()),
            'images' => ImageLightDto::fromList($product->images()->all()),
            'creator' => UserLightDto::fromModel($product->user()),
            'updatedAt' => $product->getUpdatedAtTimestamp(),
            'createdAt' => $product->getCreatedAtTimestamp(),
        ]);
    }

    /**
     * @param Product[] $items
     * @return self[]
     * @throws AppException
     */
    public function fromList(array $items): array
    {
        return array_map(fn(Product $item): self => self::fromModel($item), $items);
    }
}
