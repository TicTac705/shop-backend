<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\UnitMeasureLightDto;

class ProductEditFormDto extends BaseDto
{
    public ProductDto $product;
    /** @var \App\Dto\UnitMeasureLightDto[]  */
    public array $unitsMeasureDtoList;
    /** @var \App\Dto\Catalog\CategoryLightDto[] */
    public array $categoriesDtoList;

    /**
     * @param UnitMeasureLightDto[]  $unitsMeasureDtoList
     * @param CategoryLightDto[] $categoriesDtoList
     * @return static
     */
    public static function fromDto(ProductDto $productDto, array $unitsMeasureDtoList, array $categoriesDtoList): self
    {
        return new self([
            'product' => $productDto,
            'unitsMeasureDtoList' => $unitsMeasureDtoList,
            'categoriesDtoList' => $categoriesDtoList
        ]);
    }
}
