<?php
namespace App\Dto;

use App\Models\UnitMeasure;

class UnitMeasureLightDto extends BaseDto
{
    public string $id;
    public string $name;

    public function fromModel(UnitMeasure $unitMeasure): self
    {
        return new self([
            'id' => $unitMeasure->getId(),
            'name' => $unitMeasure->getName()
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
