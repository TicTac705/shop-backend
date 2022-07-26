<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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
    use HasFactory;

    protected $collection  = 'unit_measure';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function create(string $name, string $slug): self
    {
        $unitMeasure = new self();

        $unitMeasure->setName($name);
        $unitMeasure->setSlug($slug);

        return $unitMeasure;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }
}
