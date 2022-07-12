<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\PivotModels\Catalog\BasketProduct;

class BasketItemDto extends BaseDto
{
    public int $id;
    public int $basketId;
    public $product;
    public int $count;
    public float $price;
    public float $totalPrice;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(BasketProduct $basketItem): self
    {
        return new self([
            'id' => $basketItem->id,
            'basketId' => $basketItem->basket_id,
            'product' => $basketItem->product->only('id', 'name'),
            'count' => $basketItem->count,
            'price' => $basketItem->price,
            'totalPrice' => $basketItem->price * $basketItem->count,
            'updatedAt' => null,
            'createdAt' => null,
        ]);
    }
}
