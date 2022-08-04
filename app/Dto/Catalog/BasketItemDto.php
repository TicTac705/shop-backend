<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Exceptions\AppException;
use App\PivotModels\Catalog\BasketProduct;

class BasketItemDto extends BaseDto
{
    public ProductLightDto $product;
    public int $count;

    /**
     * @throws AppException
     */
    public static function fromModel(BasketProduct $basketItem): self
    {
        return new self([
            'product' => ProductLightDto::fromModel($basketItem->product()->first()),
            'count' => $basketItem->count,
        ]);
    }

    /**
     * @param BasketProduct[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(BasketProduct $item): self => self::fromModel($item), $items);
    }
}
