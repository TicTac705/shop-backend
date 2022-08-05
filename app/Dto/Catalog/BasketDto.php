<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Exceptions\AppException;
use App\Models\Catalog\Basket;

class BasketDto extends BaseDto
{
    public string $id;
    public ?array $items;
    public int $totalCount;
    public ?int $updatedAt;
    public ?int $createdAt;

    /**
     * @throws AppException
     */
    public static function fromModel(Basket $basket): self
    {
        return new self([
            'id' => $basket->getId(),
            'items' => BasketItemDto::fromList($basket->getPositions()),
            'totalCount' => count($basket->getPositions()),
            'updatedAt' => $basket->getUpdatedAtTimestamp(),
            'createdAt' => $basket->getCreatedAtTimestamp(),
        ]);
    }
}
