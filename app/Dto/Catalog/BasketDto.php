<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Basket;

class BasketDto extends BaseDto
{
    public int $id;
    public int $userId;
    public bool $isActive;
    /** @var \App\Dto\Catalog\BasketItemDto[] */
    public array $items;
    public int $totalCount;
    public int $updatedAt;
    public int $createdAt;

    public static function fromModel(Basket $basket): self
    {
        $itemDtoList = BasketItemDto::fromList($basket->items()->getResults()->all());

        return new self([
            'id' => $basket->getId(),
            'userId' => $basket->getUserId(),
            'isActive' => $basket->getActive(),
            'items' => $itemDtoList,
            'totalCount' => count($itemDtoList),
            'updatedAt' => $basket->updated_at->timestamp,
            'createdAt' => $basket->created_at->timestamp,
        ]);
    }
}
