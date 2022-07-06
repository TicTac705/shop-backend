<?php
namespace App\Dto;

use App\Models\UnitMeasure;

class UnitMeasureDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $slug;
    public int $updatedAt;
    public int $createdAt;

    public function fromModel(UnitMeasure $unitMeasure): self
    {
        return new self([
            'id' => $unitMeasure->id,
            'name' => $unitMeasure->name,
            'slug' => $unitMeasure->slug,
            'updatedAt' => $unitMeasure->updated_at->timestamp,
            'createdAt' => $unitMeasure->created_at->timestamp,
        ]);
    }
}
