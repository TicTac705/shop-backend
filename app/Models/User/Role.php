<?php

namespace App\Models\User;

use App\Models\ModelBase;
use App\PivotModels\User\UserRole;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Role extends ModelBase
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string'
    ];

    public static function create(
        string $name,
        string $slug
    ): self
    {
        $userRole = new self();

        $userRole->setSlug($slug);
        $userRole->setName($name);

        return $userRole;
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

    public function checkBySlug(string $slug): bool
    {
        return self::where('slug', $slug)->exists();
    }

    public function getIdBySlug(string $slug): string
    {
        return self::where('slug', $slug)->first()->id;
    }

    public function getSlugById(string $id): string
    {
        return self::where('id', $id)->first()->slug;
    }
}
