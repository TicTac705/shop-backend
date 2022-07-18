<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\PivotModels\Catalog\OrderProduct;

class OrderItemDto extends BaseDto
{
    public ProductLightForOrderDto $product;
    public float $price;
    public int $count;

    public static function fromModel(OrderProduct $orderItem): self
    {
        return new self([
            'product' => ProductLightForOrderDto::fromModel($orderItem->product()->getResults()),
            'price' => $orderItem->getPrice(),
            'count' => $orderItem->getCount(),
        ]);
    }

    /**
     * @param OrderProduct[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(OrderProduct $item): self => self::fromModel($item), $items);
    }
}
