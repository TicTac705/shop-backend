<?php

namespace Tests\Helpers;

use App\Models\UnitMeasure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait UnitMeasureTrait
{
    protected Collection $unitMeasures;

    public function createDefaultsUnitMeasures(): void
    {
        $this->unitMeasures = UnitMeasure::factory()->count(2)->state(new Sequence(
            ['name' => 'Kilogram', 'slug' => 'kg'],
            ['name' => 'Piece', 'slug' => 'piece']
        ))->create();
    }
}
