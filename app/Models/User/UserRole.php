<?php

namespace App\Models\User;

use App\Models\ModelBase;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 *
 */
class UserRole extends ModelBase
{
    protected $table = 'user_role';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function getName():string
    {
        return $this->name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function setName(string $name):void
    {
        $this->name = $name;
        $this->save();
    }

    public function setSlug(string $slug):void
    {
        $this->name = $slug;
        $this->save();
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
