<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 *
 */
class UnitMeasure extends Model
{
    protected $collection = 'unit_measure';

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
