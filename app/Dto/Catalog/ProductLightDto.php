<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\ImageLightDto;
use App\Dto\UnitMeasureLightDto;
use App\Dto\User\UserLightDto;
use App\Models\Catalog\Product;

class ProductLightDto extends BaseDto
{
    public string $id;
    public string $name;
    public float $price;
    public UnitMeasureLightDto $unitMeasure;
    public int $store;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categories;
    /** @var \App\Dto\ImageLightDto[] */
    public array $images;


    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'unitMeasure' => UnitMeasureLightDto::fromModel($product->unitMeasure()),
            'store' => $product->getStore(),
            'categories' => CategoryLightDto::fromList($product->categories()->all()),
            'images' => ImageLightDto::fromList($product->images()->all()),
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
