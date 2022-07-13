<?php

namespace App\Dto;

use App\Models\UnitMeasure;

class UnitMeasureDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $slug;
    public ?int $updatedAt;
    public ?int $createdAt;

    public function fromModel(UnitMeasure $unitMeasure): self
    {
        return new self([
            'id' => $unitMeasure->getId(),
            'name' => $unitMeasure->getName(),
            'slug' => $unitMeasure->getSlug(),
            'updatedAt' => $unitMeasure->getUpdatedAtTimestamp(),
            'createdAt' => $unitMeasure->getCreatedAtTimestamp(),
        ]);
    }

    /**
     * @param UnitMeasure[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(UnitMeasure $item): self => self::fromModel($item), $items);
    }
}
