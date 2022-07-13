<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\ImageLightDto;
use App\Dto\UnitMeasureLightDto;
use App\Dto\User\UserLightDto;
use App\Models\Catalog\Product;

class ProductDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public UnitMeasureLightDto $unitMeasure;
    public int $store;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categories;
    /** @var \App\Dto\ImageLightDto[] */
    public array $images;
    public UserLightDto $creator;
    public ?int $updatedAt;
    public ?int $createdAt;


    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'unitMeasure' => UnitMeasureLightDto::fromModel($product->unitMeasure()->getResults()),
            'store' => $product->getStore(),
            'categories' => CategoryLightDto::fromList($product->categories()->getResults()->all()),
            'images' => ImageLightDto::fromList($product->images()->getResults()->all()),
            'creator' => UserLightDto::fromModel($product->user()->getResults()),
            'updatedAt' => $product->getUpdatedAtTimestamp(),
            'createdAt' => $product->getCreatedAtTimestamp(),
        ]);
    }

    /**
     * @param Product[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(Product $item): self => self::fromModel($item), $items);
    }
}
