<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\UnitMeasureLightDto;

class ProductEditFormDto extends BaseDto
{
    public ProductDto $product;
    /** @var \App\Dto\UnitMeasureLightDto[]  */
    public array $unitsMeasureList;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categoriesList;

    /**
     * @param UnitMeasureLightDto[]  $unitsMeasureDtoList
     * @param CategoryLightDto[] $categoriesDtoList
     * @return static
     */
    public static function fromDto(ProductDto $productDto, array $unitsMeasureDtoList, array $categoriesDtoList): self
    {
        return new self([
            'product' => $productDto,
            'unitsMeasureList' => $unitsMeasureDtoList,
            'categoriesList' => $categoriesDtoList
        ]);
    }
}
