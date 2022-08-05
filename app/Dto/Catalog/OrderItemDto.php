<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Exceptions\AppException;
use App\PivotModels\Catalog\OrderProduct;

class OrderItemDto extends BaseDto
{
    public ProductLightForOrderDto $product;
    public float $price;
    public int $count;

    /**
     * @throws AppException
     */
    public static function fromModel(OrderProduct $orderItem): self
    {
        return new self([
            'product' => ProductLightForOrderDto::fromModel($orderItem->product()->first()),
            'price' => $orderItem->price,
            'count' => $orderItem->count,
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
