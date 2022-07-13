<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\PivotModels\Catalog\BasketProduct;

class BasketItemDto extends BaseDto
{
    public int $id;
    public int $basketId;
    public ProductDto $product;
    public int $count;
    public float $price;
    public float $totalPrice;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(BasketProduct $basketItem): self
    {
        return new self([
            'id' => $basketItem->getId(),
            'basketId' => $basketItem->getBasketId(),
            'product' => ProductDto::fromModel($basketItem->product()->getResults()),
            'count' => $basketItem->getCount(),
            'price' => $basketItem->getPrice(),
            'totalPrice' => $basketItem->getPrice() * $basketItem->getCount(),
            'updatedAt' => $basketItem->getUpdatedAtTimestamp(),
            'createdAt' => $basketItem->getCreatedAtTimestamp(),
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
