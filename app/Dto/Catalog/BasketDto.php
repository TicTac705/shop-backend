<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\User\UserLightDto;
use App\Models\Catalog\Basket;

class BasketDto extends BaseDto
{
    public int $id;
    public UserLightDto $creator;
    public bool $isActive;
    /** @var \App\Dto\Catalog\BasketItemDto[] */
    public array $items;
    public int $totalCount;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(Basket $basket): self
    {
        $itemDtoList = BasketItemDto::fromList($basket->items()->getResults()->all());

        return new self([
            'id' => $basket->getId(),
            'creator' => UserLightDto::fromModel($basket->user()->getResults()),
            'isActive' => $basket->getActive(),
            'items' => $itemDtoList,
            'totalCount' => count($itemDtoList),
            'updatedAt' => $basket->getUpdatedAtTimestamp(),
            'createdAt' => $basket->getCreatedAtTimestamp(),
        ]);
    }
}
