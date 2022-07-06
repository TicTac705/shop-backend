<?php

namespace App\Models;

use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class UnitMeasure extends ModelBase
{
    protected $table = 'unit_measure';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function checkBySlug(string $slug): bool
    {
        return UnitMeasure::where('slug', $slug)->exists();
    }

    public function getIdBySlug(string $slug): string
    {
        return UnitMeasure::where('slug', $slug)->first()->id;
    }
}
