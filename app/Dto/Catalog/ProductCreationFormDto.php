<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\UnitMeasureLightDto;

class ProductCreationFormDto extends BaseDto
{
    /** @var \App\Dto\UnitMeasureLightDto[]  */
    public array $unitsMeasureList;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categoriesList;

    /**
     * @param UnitMeasureLightDto[]  $unitsMeasureDtoList
     * @param CategoryLightDto[] $categoriesDtoList
     * @return static
     */
    public static function fromDto(array $unitsMeasureDtoList, array $categoriesDtoList): self
    {
        return new self([
            'unitsMeasureList' => $unitsMeasureDtoList,
            'categoriesList' => $categoriesDtoList
        ]);
    }
}
