<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Basket;

class BasketDto extends BaseDto
{
    public string $id;
    public ?array $items;
    public int $totalCount;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(Basket $basket): self
    {
        $itemDtoList = BasketItemDto::fromList($basket->items()->all());

        return new self([
            'id' => $basket->getId(),
            'items' => $basket->getPositions(),
            'totalCount' => count($itemDtoList),
            'updatedAt' => $basket->getUpdatedAtTimestamp(),
            'createdAt' => $basket->getCreatedAtTimestamp(),
        ]);
    }
}
