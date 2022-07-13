<?php

namespace App\Services;

use App\Models\UnitMeasure;

class UnitMeasureService
{
    /**
     * @return UnitMeasure[]
     */
    public function getAll(): array
    {
        return UnitMeasure::all()->all();
    }
}
