<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Basket;

class BasketDto extends BaseDto
{
    public int $id;
    public int $userId;
    public bool $isActive;
    public BasketItemDtoCollection $items;
    public int $totalCount;
    public int $updatedAt;
    public int $createdAt;

    public static function fromModel(Basket $basket): self
    {
        $itemCollection = $basket->items;

        return new self([
            'id' => $basket->id,
            'userId' => $basket->user_id,
            'isActive' => $basket->is_active,
            'items' => (new BasketItemDtoCollection($itemCollection->all()))->only(['id', 'product', 'count', 'price', 'totalPrice']),
            'totalCount' => $itemCollection->count(),
            'updatedAt' => $basket->updated_at->timestamp,
            'createdAt' => $basket->created_at->timestamp,
        ]);
    }
}
