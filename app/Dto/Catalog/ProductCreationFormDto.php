<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\UnitMeasureLightDto;

class ProductCreationFormDto extends BaseDto
{
    /** @var \App\Dto\UnitMeasureLightDto[]  */
    public array $unitsMeasureDtoList;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categoriesDtoList;

    /**
     * @param UnitMeasureLightDto[]  $unitsMeasureDtoList
     * @param CategoryLightDto[] $categoriesDtoList
     * @return static
     */
    public static function fromDto(array $unitsMeasureDtoList, array $categoriesDtoList): self
    {
        return new self([
            'unitsMeasureDtoList' => $unitsMeasureDtoList,
            'categoriesDtoList' => $categoriesDtoList
        ]);
    }
}
