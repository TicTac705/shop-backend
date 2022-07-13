<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Basket;

class BasketDto extends BaseDto
{
    /** @var \App\Dto\Catalog\BasketItemDto[] */
    public array $items;
    public int $totalCount;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(Basket $basket): self
    {
        $itemDtoList = BasketItemDto::fromList($basket->items()->getResults()->all());

        return new self([
            'items' => $itemDtoList,
            'totalCount' => count($itemDtoList),
            'updatedAt' => $basket->getUpdatedAtTimestamp(),
            'createdAt' => $basket->getCreatedAtTimestamp(),
        ]);
    }
}
