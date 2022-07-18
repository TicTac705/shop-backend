<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\ImageLightDto;
use App\Dto\UnitMeasureLightDto;
use App\Dto\User\UserLightDto;
use App\Models\Catalog\Product;

class ProductLightForOrderDto extends BaseDto
{
    public int $id;
    public string $name;
    public UnitMeasureLightDto $unitMeasure;
    /** @var \App\Dto\ImageLightDto[] */
    public array $images;


    public static function fromModel(Product $product): self
    {
        return new self([
            'id' => $product->getId(),
            'name' => $product->getName(),
            'unitMeasure' => UnitMeasureLightDto::fromModel($product->unitMeasure()->getResults()),
            'images' => ImageLightDto::fromList($product->images()->getResults()->all()),
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
