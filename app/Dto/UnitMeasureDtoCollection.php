<?php

namespace App\Dto;

use App\Models\UnitMeasure;

class UnitMeasureDtoCollection extends BaseDtoCollection
{

    /**
     * @param UnitMeasure[] $data
     */
    public function __construct(array $data)
    {
        $collection = array_map(fn(UnitMeasure $item): UnitMeasureDto => UnitMeasureDto::fromModel($item), $data);

        parent::__construct($collection);
    }
}
