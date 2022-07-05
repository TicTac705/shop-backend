<?php

namespace App\Models\User;

use App\Models\ModelBase;
use App\PivotModels\User\UserRole;

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
        return UserRole::where('slug', $slug)->exists();
    }

    public function getIdBySlug(string $slug): string
    {
        return UserRole::where('slug', $slug)->first()->id;
    }

    public function getSlugById(string $id): string
    {
        return UserRole::where('_id', $id)->first()->slug;
    }
}
